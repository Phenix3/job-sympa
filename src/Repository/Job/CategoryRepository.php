<?php

namespace App\Repository\Job;

use App\Entity\Job\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function add(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * @param int|null $limit
     * @return float|int|mixed|string
     */
    public function findLatest(?int $limit = 12): mixed
    {
        $data = $this->createQueryBuilder('c')
            ->join('c.jobs', 'j')
            ->groupBy('c.id')
            ->select('c', 'COUNT(c.id) as count')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;

        return array_map(function(array $d) {
            $d[0]->setJobsCount((int) $d['count']);
            return $d[0];
        }, $data);
    }
}
