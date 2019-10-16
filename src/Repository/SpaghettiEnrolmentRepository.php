<?php

namespace App\Repository;

use App\Entity\SpaghettiEnrolment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpaghettiEnrolment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpaghettiEnrolment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpaghettiEnrolment[]    findAll()
 * @method SpaghettiEnrolment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpaghettiEnrolmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpaghettiEnrolment::class);
    }

    // /**
    //  * @return SpaghettiEnrolment[] Returns an array of SpaghettiEnrolment objects
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
    public function findOneBySomeField($value): ?SpaghettiEnrolment
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
