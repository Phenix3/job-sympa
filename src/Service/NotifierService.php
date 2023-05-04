<?php

namespace App\Service;

use App\Encoder\PathEncoder;
use App\Entity\Job\Application;
use App\Entity\Notification;
use App\Entity\User\User;
use App\Event\Notification\NotificationCreatedEvent;
use App\Event\Notification\NotificationReadEvent;
use App\Notifier\JobAppliedNotification;

use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\Translation\t;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Notifier\Notification\Notification as SfNotification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Notifier\Recipient\RecipientInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class NotifierService
{
    public function __construct(
        private NotifierInterface $notifier,
        private UrlGeneratorInterface $urlGenerator,
        private EntityManagerInterface $em,
        private EventDispatcherInterface $eventDispatcher,
        private SerializerInterface $serializer,
        private Security $security
    ) {
    }

    /**
     * @param string $title
     * @param string $content
     * @param string|null $importance
     * @param array|null $channels
     * @return SfNotification|NotificationEmail
     */
    public function createNotification(string $title, string $content, ?string $importance = SfNotification::IMPORTANCE_MEDIUM, ?array $channels = ['email']): SfNotification|NotificationEmail
    {
        /** @var NotificationEmail $notification */
        $notification = (new SfNotification($title, $channels))
            ->content($content)
            ->importance($importance);

        return $notification;
    }

    public function send(SfNotification $notification, ?RecipientInterface $recipient = null): void
    {
        $this->notifier->send($notification, $recipient);
    }

    public function sendJobAppliedNotificationToEmployer(Application $application): void
    {
        $notification = $this->createNotification(
            'ui.alerts.job_applied',
            'ui.alerts.job_applied_content',
            SfNotification::IMPORTANCE_HIGH,
            ['email']
        );

        $recipient = new Recipient($application->getJob()->getCompany()->getEmail());
        $this->send($notification, $recipient);
    }

    public function sendJobAppliedNotificationToCandidate(Application $application): void
    {
        $notification = $this->createNotification(
            'ui.alerts.job_applied',
            'ui.alerts.job_applied_content',
            SfNotification::IMPORTANCE_HIGH,
            ['email']
        );

        $recipient = new Recipient($application->getCandidate()->getEmail());

        $this->send($notification, $recipient);
    }

    /**
     * Envoie une notification sur un canal particulier.
     */
    public function notifyChannel(
        string $channel,
        User $user,
        string $title,
        string $content,
        int $type,
        int $for,
        ?object $entity = null
        ): Notification
    {
        /** @var string $url */
        $url = $entity ? $this->serializer->serialize($entity, PathEncoder::FORMAT) : null;
        $notification = (new Notification())
            ->setTitle($title)
            ->setContent($content)
            ->setUser($user)
            ->setUrl($url)
            ->setType($type)
            ->setNotificationFor($for)
            ->setTarget($entity ? $this->getHashForEntity($entity) : null)
            ->setCreatedAt(new \DateTime())
            ->setChannel($channel);
        $this->em->persist($notification);
        $this->em->flush();
        $this->eventDispatcher->dispatch(new NotificationCreatedEvent($notification));

        return $notification;
    }

    public function notifyUser(
        User $user,
        string $title,
        string $content,
        int $type,
        int $for,
        ?object $entity
        ): Notification
    {
        // $url = $entity ? $this->serializer->serialize($entity, PathEncoder::FORMAT) : null;

        $notification = (new Notification())
            ->setTitle($title)
            ->setContent($content)
            ->setType($type)
            ->setNotificationFor($for)
            ->setUser($user)
            ->setTarget($this->getHashForEntity($entity))
            ->setCreatedAt(new \DateTime());

        /** @var NotificationRepository $repo */
        $repo = $this->em->getRepository(Notification::class);

        $repo->persistOrUpdate($notification);
        $this->em->flush();
        $this->eventDispatcher->dispatch(new NotificationCreatedEvent($notification));

        return $notification;
    }

    /**
     * @return Notification[]
     */
    public function forUser(User $user): array
    {
        /** @var NotificationRepository $repository */
        $repository = $this->em->getRepository(Notification::class);

        return $repository->findRecentForUser($user, $this->getChannelsForUser($user));
    }

    public function readAll(User $user): void
    {
        $user->setNotificationsReadAt(new \DateTime());
        $this->em->flush();
        $this->eventDispatcher->dispatch(new NotificationReadEvent($user));
    }

    /**
     * Renvoie les salons auquel l'utilisateur peut s'abonner.
     *
     * @return string[]
     */
    public function getChannelsForUser(User $user): array
    {
        $channels = [
            'user/' . $user->getId(),
            'public',
        ];

        // if ($this->security->isGranted(ChannelVoter::LISTEN_ADMIN)) {
        //     $channels[] = 'admin';
        // }

        return $channels;
    }

    /**
     * Extrait un hash pour une notification className::id.
     */
    private function getHashForEntity(object $entity): string
    {
        $hash = $entity::class;
        if (method_exists($entity, 'getId')) {
            $hash .= '::' . (string) $entity->getId();
        }

        return $hash;
    }
}
