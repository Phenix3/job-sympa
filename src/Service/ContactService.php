<?php

namespace App\Service;

use App\Dto\ContactRequestData;
use App\Entity\ContactRequest;
use App\Exception\TooManyContactException;
use App\Repository\ContactRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class ContactService
{
	public function __construct(private ContactRequestRepository $repository, private EntityManagerInterface $em, private MailerInterface $mailer){}

	public function send(ContactRequestData $data, Request $request): void
	{
		$contactRequest = (new ContactRequest())
			->setName($data->name)
			->setEmail($data->email)
			->setSubject($data->subject)
			->setContent($data->content)
			->setRawIp($request->getClientIp());
		$lastRequest = $this->repository->findLastRequestForIp($contactRequest->getIp());

		if ($lastRequest && $lastRequest->getCreatedAt() > new \DateTime('-1 hour')) {
			throw new TooManyContactException('Trop de tentative de contact');
		}

		if (null !== $lastRequest) {
			$lastRequest->setCreatedAt(new \DateTime());
		} else {
			$this->em->persist($contactRequest);
		}

		$this->em->flush();

		$message = (new Email())
            ->text($data->content)
            ->subject("Job::Contact : {$data->name}")
            ->from('noreply@job-sympa.com')
            ->replyTo(new Address($data->email, $data->name))
            ->to('contact@job-sympa.com');
        $this->mailer->send($message);
	}
}