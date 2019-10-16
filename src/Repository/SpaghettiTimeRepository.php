<?php

namespace App\Repository;

use App\Entity\SpaghettiTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpaghettiTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpaghettiTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpaghettiTime[]    findAll()
 * @method SpaghettiTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpaghettiTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpaghettiTime::class);
    }

    // /**
    //  * @return SpaghettiTime[] Returns an array of SpaghettiTime objects
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
    public function findOneBySomeField($value): ?SpaghettiTime
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
