<?php

namespace App\Repository\User;

use App\Dto\EmployerSearchData;
use App\Entity\User\Employer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Employer>
 *
 * @method Employer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employer[]    findAll()
 * @method Employer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployerRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employer::class);
    }

    public function add(Employer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Employer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Employer) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }


    public function searchEmployersQuery(?EmployerSearchData $employersSearchData = null): Query
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.category', 'c')
            ->leftJoin('e.country', 'country')
            ->addSelect('c', 'country')
        ;

        if (null === $employersSearchData) {
            return $qb->getQuery();
        }

        if ($employersSearchData->name) {
            $qb = $qb->orWhere("e.username LIKE :name")
                ->setParameter('name', "%{$employersSearchData->name}%")
                ->orderBy('e.username', 'DESC');
        }

        if (!empty($employersSearchData->categories)) {
            $qb = $qb->orWhere("c IN (:categories)")
                ->setParameter('categories', $employersSearchData->categories);
        }

        if (!empty($employersSearchData->country)) {
            $qb = $qb->orWhere("country.name LIKE :country")
                ->orWhere('e.city LIKE :country')
                ->setParameter('country', "%{$employersSearchData->country}%")
                ->addOrderBy('country.name', 'ASC');
        }

        if (!empty($employersSearchData->ceo)) {
            $qb = $qb->orWhere("e.ceo LIKE :ceo")
                ->setParameter('ceo', "%{$employersSearchData->ceo}%")
                ->addOrderBy('e.ceo', 'ASC');
        }

        return $qb->getQuery();
    }
}
