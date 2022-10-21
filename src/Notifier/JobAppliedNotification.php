<?php

namespace App\Notifier;

use App\Entity\Job\Application;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use function Symfony\Component\Translation\t;

class JobAppliedNotification extends Notification implements EmailNotificationInterface
{

    public function __construct(Application $application, string $subject = '', array $channels = [])
    {
        parent::__construct($subject, $channels);
    }

    public function asEmailMessage(EmailRecipientInterface $recipient, string $transport = null): ?EmailMessage
    {
        $message = EmailMessage::fromNotification($this, $recipient, $transport);
        $message
            ->content(t('ui.alerts.job_applied_content'))
            ->action('Action1', '');
        return $message;
    }
}