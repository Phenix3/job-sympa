<?php

namespace App\Service;

use App\Entity\Job\Application;
use App\Notifier\JobAppliedNotification;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Notifier\Recipient\RecipientInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use function Symfony\Component\Translation\t;

class NotifierService
{
    public function __construct(private NotifierInterface $notifier, private UrlGeneratorInterface $urlGenerator)
    {}

    /**
     * @param string $title
     * @param string $content
     * @param string|null $importance
     * @param array|null $channels
     * @return Notification|NotificationEmail
     */
    public function createNotification(string $title, string $content, ?string $importance = Notification::IMPORTANCE_MEDIUM, ?array $channels = ['email']): Notification|NotificationEmail
    {
        /** @var NotificationEmail $notification */
        $notification = (new Notification($title, $channels))
            ->content($content)
            ->importance($importance)
            ;
        return $notification;
    }

    public function send(Notification $notification, ?RecipientInterface $recipient = null): void
    {
        $this->notifier->send($notification, $recipient);
    }

    public function sendJobAppliedNotificationToEmployer(Application $application): void
    {
        $notification = $this->createNotification(
            'ui.alerts.job_applied', 'ui.alerts.job_applied_content',
            Notification::IMPORTANCE_HIGH,
            ['email']
        )
           /* ->action(
                'ui.buttons.view_applications',
                $this->urlGenerator->generate('app_front_employer_job_applications', ['slug' => $application->getJob()->getSlug()])
            )*/;

        $recipient = new Recipient($application->getJob()->getCompany()->getEmail());

        $this->send($notification, $recipient);
    }

    public function sendJobAppliedNotificationToCandidate(Application $application): void
    {
        $notification = $this->createNotification(
            'ui.alerts.job_applied',
            'ui.alerts.job_applied_content',
            Notification::IMPORTANCE_HIGH,
            ['email']
        )
            /*->action(
                'ui.buttons.view_applications',
                $this->urlGenerator->generate('app_front_candidate_applications', ['slug' => $application->getJob()->getSlug()])
            )*/;

//        $notification = new JobAppliedNotification($application, t('ui.alerts.job_applied'), ['email']);

        $recipient = new Recipient($application->getCandidate()->getEmail());

        $this->send($notification, $recipient);
    }
}