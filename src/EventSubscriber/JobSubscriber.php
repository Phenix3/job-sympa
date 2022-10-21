<?php

namespace App\EventSubscriber;

use App\Event\Job\ApplicationDeletedEvent;
use App\Event\Job\JobAppliedEvent;
use App\Service\MailerService;
use App\Service\NotifierService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use function Symfony\Component\Translation\t;

class JobSubscriber implements EventSubscriberInterface
{
    /**
     * @param MailerService $mailerService
     */
    public function __construct(private MailerService $mailerService, private NotifierService $notifierService)
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
//        $this->notifierService->sendJobAppliedNotificationToEmployer($event->getApplication());
        $this->notifierService->sendJobAppliedNotificationToCandidate($event->getApplication());

        $job = $event->getApplication()->getJob();
        $candidate = $event->getApplication()->getCandidate();

        $email = $this->mailerService->createEmail('mails/user/employer/job_applied.twig', [
            'job' => $job,
            'employer' => $job->getCompany()
        ])
            ->to($candidate->getEmail())
            ->subject(t('ui.mails.subjects.employer_job_applied'))
        ;

        $this->mailerService->sendNow($email);
    }
}
