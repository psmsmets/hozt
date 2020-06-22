<?php

namespace App\Repository;

use App\Entity\TrainingTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrainingTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingTime[]    findAll()
 * @method TrainingTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingTime::class);
    }

    // /**
    //  * @return TrainingTime[] Returns an array of TrainingTime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrainingTime
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
