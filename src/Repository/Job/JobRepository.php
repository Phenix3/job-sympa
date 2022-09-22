<?php

namespace App\Repository\Job;

use App\Entity\Job\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Job>
 *
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    public function add(Job $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Job $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPopularJobs(int $limit = 8): ?array
    {
        return $this
            ->createQueryBuilder('j')
            ->orderBy('j.publishedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $id
     * @return float|int|mixed|string
     * @throws NonUniqueResultException
     */
    public function findJobWithRelations(int $id): mixed
    {
        return $this->createQueryBuilder('j')
            ->leftJoin('j.categories', 'categories')
            ->leftJoin('j.requiredSkills', 'requiredSkills')
            ->where("j.id = :id")
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function searchJobs(?\App\Dto\JobSearchData $jobSearchData = null): \Doctrine\ORM\Query
    {

        $query =  $this
            ->createQueryBuilder('j')
            ->leftJoin('j.categories', 'c')
            ->leftJoin('j.requiredSkills', 'requiredSkills')
            ->addSelect('j', 'c', 'requiredSkills')
            ;

        if (null === $jobSearchData) {
            return $query->getQuery();
        }

        if ($jobSearchData->query) {
            $query = $query->where("j.title LIKE :title")->setParameter('title', "%{$jobSearchData->query}%");
        }

        if (!empty($jobSearchData->categories)) {
            $query = $query->andWhere("c IN (:categories)")->setParameter('categories', $jobSearchData->categories);
        }

        return $query->getQuery();
    }
}
