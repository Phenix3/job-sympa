<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 *
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function save(Notification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Notification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param string[] $channels
     *
     * @return Notification[]
     */
    public function findRecentForUser(User $user, array $channels = ['public']): array
    {
        return array_map(fn ($n) => (clone $n)->setUser($user), $this->createQueryBuilder('notif')
            ->orderBy('notif.createdAt', 'DESC')
            ->setMaxResults(10)
            ->where('notif.user = :user')
            ->orWhere('notif.user IS NULL AND notif.channel IN (:channels)')
            ->setParameter('user', $user)
            ->setParameter('channels', $channels)
            ->getQuery()
            ->getResult());
    }

    /**
     * Persiste une nouvelle notification ou met à jour une notification précédente.
     */
    public function persistOrUpdate(Notification $notification): Notification
    {
        if (null === $notification->getUser()) {
            $this->getEntityManager()->persist($notification);

            return $notification;
        }
        $oldNotification = $this->findOneBy([
            'user' => $notification->getUser(),
            'target' => $notification->getTarget(),
        ]);
        if ($oldNotification) {
            $oldNotification->setCreatedAt($notification->getCreatedAt());
            $oldNotification->setContent($notification->getContent());

            return $oldNotification;
        } else {
            $this->getEntityManager()->persist($notification);

            return $notification;
        }
    }

    /**
     * Supprime les anciennes notifications.
     */
    public function clean(): int
    {
        return $this->createQueryBuilder('n')
            ->where('n.createdAt < :date')
            ->setParameter('date', new \DateTime('-3 month'))
            ->delete(Notification::class, 'n')
            ->getQuery()
            ->execute();
    }
}
