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
use Symfony\Component\Security\Core\User\UserInterface;

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
            ->activeJobsBuilder()
            ->leftJoin('j.jobBookmarks', 'bookmarks')
            ->leftJoin('j.company', 'company')
            ->addSelect('bookmarks', 'company')
            ->addOrderBy('j.publishedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    public function activeJobsBuilder(?string $alias = 'j'): QueryBuilder
    {
        $date = Carbon::now()->toDateString();
        return $this->createQueryBuilder($alias)
            ->andWhere("{$alias}.deadline <= :date")
            ->setParameter('date', $date)
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
            ->andWhere("j.id = :id")
            ->addOrderBy("j.createdAt", 'DESC')
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
            ->leftJoin('j.type', 't')
<<<<<<< HEAD
            ->leftJoin('j.country', 'country')
=======
>>>>>>> origin/master
            ->leftJoin('j.requiredSkills', 'requiredSkills')
            ->addSelect('c', 'requiredSkills', 'country')
            ;

        if (null === $jobSearchData) {
            return $query->getQuery();
        }

        // Searc by Job title
        if ($jobSearchData->query) {
            $query = $query->andWhere("j.title LIKE :title")->setParameter('title', "%{$jobSearchData->query}%");
        }

        // Searc by Job location country
        if ($jobSearchData->country) {
            $query = $query->andWhere("j.country IN (:country)")->setParameter('country', $jobSearchData->country);
        }

        /*if ($jobSearchData->location) {
            $query = $query->andWhere("j.location LIKE :location")->setParameter('location', "%{$jobSearchData->location}%");
        }*/

        // Searc by Job categories
        if (!empty($jobSearchData->categories)) {
            $query = $query->andWhere("c IN (:categories)")->setParameter('categories', $jobSearchData->categories);
        }

        // Searc by Job types (full_time, part_time, freelance)
        if (!empty($jobSearchData->types)) {
            $query = $query->andWhere("t IN (:types)")->setParameter('types', $jobSearchData->types);
        }

        // Sorting
        if ($jobSearchData->sort) {
            $query = $query->addOrderBy("j.{$jobSearchData->sort}", $jobSearchData?->direction ? $jobSearchData?->direction : 'DESC');
        } else {
            $query = $query->addOrderBy("j.createdAt", 'DESC');
        }


        return $query->getQuery();
    }

    public function findAllForEmployerQuery(Employer $employer): Query
    {
        return $this->activeJobsBuilder('job')
            ->leftJoin('job.applications', 'applications')
            ->addSelect('applications')
            ->andWhere('job.company = :company')
            ->setParameter('company', $employer)
            ->addOrderBy('job.createdAt', 'DESC')
            ->getQuery()
            ;
    }

    public function findJobWithBookmarksQuery(int $id, ?UserInterface $user = null)
    {
        $query = $this->activeJobsBuilder('j')
            ->leftJoin('j.jobBookmarks', 'jb')
            ->addSelect('jb')
            ->andWhere('j.id = :id')
            ->addOrderBy("j.createdAt", 'DESC')
            ->setParameter('id', $id)
            ->setMaxResults(1)
        ;

        return $query
            ->getQuery()
        ;
    }
}
