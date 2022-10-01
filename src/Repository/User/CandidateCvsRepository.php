<?php

namespace App\Repository\User;

use App\Entity\User\Candidate;
use App\Entity\User\CandidateCvs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CandidateCvs>
 *
 * @method CandidateCvs|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidateCvs|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidateCvs[]    findAll()
 * @method CandidateCvs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidateCvsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidateCvs::class);
    }

    public function add(CandidateCvs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CandidateCvs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Candidate $candidate
     * @return Query
     */
    public function findForCandidateQuery(Candidate $candidate): Query
    {
        return $this->createQueryBuilder('cc')
            ->where('cc.candidate = :candidate')
            ->orderBy('cc.id', 'DESC')
            ->setParameter('candidate', $candidate)
            ->getQuery()
            ;
    }

//    /**
//     * @return CandidateCvs[] Returns an array of CandidateCvs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CandidateCvs
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
