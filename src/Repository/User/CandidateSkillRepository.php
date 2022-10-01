<?php

namespace App\Repository\User;

use App\Entity\User\Candidate;
use App\Entity\User\CandidateSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CandidateSkill>
 *
 * @method CandidateSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidateSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidateSkill[]    findAll()
 * @method CandidateSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidateSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidateSkill::class);
    }

    public function add(CandidateSkill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CandidateSkill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Candidate $candidate
     * @return float|int|mixed|string
     */
    public function findForCandidate(Candidate $candidate): mixed
    {
        return $this->createQueryBuilder('cs')
            ->where('cs.candidate = :candidate')
            ->setParameter('candidate', $candidate)
            ->orderBy('cs.level', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return CandidateSkill[] Returns an array of CandidateSkill objects
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

//    public function findOneBySomeField($value): ?CandidateSkill
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
