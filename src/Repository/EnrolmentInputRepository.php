<?php

namespace App\Repository;

use App\Entity\EnrolmentInput;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EnrolmentInput|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnrolmentInput|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnrolmentInput[]    findAll()
 * @method EnrolmentInput[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnrolmentInputRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnrolmentInput::class);
    }

    // /**
    //  * @return EnrolmentInput[] Returns an array of EnrolmentInput objects
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
    public function findOneBySomeField($value): ?EnrolmentInput
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
