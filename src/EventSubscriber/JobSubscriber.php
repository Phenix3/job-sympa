<?php

namespace App\EventSubscriber;

use App\Event\Job\ApplicationDeletedEvent;
use App\Event\Job\JobAppliedEvent;
use App\Service\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class JobSubscriber implements EventSubscriberInterface
{
    /**
     * @param MailerService $mailerService
     */
    public function __construct(private MailerService $mailerService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            JobAppliedEvent::class => 'onJobApplied',
            ApplicationDeletedEvent::class => 'onApplicationDeleted'
        ];
    }

    public function onApplicationDeleted(ApplicationDeletedEvent $event)
    {
        $application = $event->getApplication();
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function onJobApplied(JobAppliedEvent $event)
    {
        $job = $event->getApplication()->getJob();
        $candidate = $event->getApplication()->getCandidate();

        $email = $this->mailerService->createEmail('mails/user/candidate/job_applied.twig', [
            'job' => $job,
            'candidate' => $candidate
        ])
            ->to($candidate->getEmail())
            ->subject('SahelJob :: Notification')
        ;

        $this->mailerService->sendNow($email);
    }
}
