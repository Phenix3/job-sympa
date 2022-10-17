<?php

namespace App\Repository\Job;

use App\Dto\JobSearchData;
use App\Entity\Job\Job;
use App\Entity\User\Employer;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
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

    public function activeJobsBuilder(?string $alias = 'j'): QueryBuilder
    {
        return $this->createQueryBuilder($alias)
//            ->andWhere($alias.'.deadline <= '. Carbon::now()->toDateString())
            ->orderBy("$alias.createdAt", 'DESC')
            ;
    }

    /**
     * @param int $id
     * @return float|int|mixed|string
     * @throws NonUniqueResultException
     */
    public function findJobWithRelations(int $id): mixed
    {
        return $this->activeJobsBuilder()
            ->leftJoin('j.categories', 'categories')
            ->leftJoin('j.requiredSkills', 'requiredSkills')
            ->addSelect('requiredSkills', 'categories')
            ->where("j.id = :id")
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function searchJobs(?JobSearchData $jobSearchData = null): Query
    {

        $query =  $this
            ->activeJobsBuilder()
            ->leftJoin('j.categories', 'c')
            ->leftJoin('j.requiredSkills', 'requiredSkills')
            ->addSelect('c', 'requiredSkills')
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

    public function findAllForEmployerQuery(Employer $employer): Query
    {
        return $this->createQueryBuilder('job')
            ->leftJoin('job.applications', 'applications')
            ->addSelect('applications')
            ->where('job.company = :company')
            ->setParameter('company', $employer)
            ->orderBy('job.createdAt', 'DESC')
            ->getQuery()
            ;
    }
}
