<?php

namespace App\Repository\User;

use App\Entity\Job\Job;
use App\Entity\User\JobBookmark;
use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<JobBookmark>
 *
 * @method JobBookmark|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobBookmark|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobBookmark[]    findAll()
 * @method JobBookmark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobBookmarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobBookmark::class);
    }

    public function add(JobBookmark $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JobBookmark $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Undocumented function
     *
     * @return Query
     */
    public function findForCandidateQuery(UserInterface $user, Job $job): Query
    {
        return $this->createQueryBuilder('jb')
            ->andWhere('jb.user = :user')
            ->andWhere('jb.job = :j')
            ->addOrderBy('jb.id', 'DESC')
            ->setParameter('user', $user)
            ->setParameter('j', $job)
            ->getQuery()
            ;
    }

    /**
     * Undocumented function
     *
     * @return Query
     */
    public function findAllForCandidateQuery(UserInterface $user): Query
    {
        return $this->createQueryBuilder('jb')
            ->andWhere('jb.user = :user')
            ->addOrderBy('jb.id', 'DESC')
            ->setParameter('user', $user)
            ->getQuery()
            ;
    }

}
