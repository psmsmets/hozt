<?php

namespace App\Repository;

use App\Entity\EnrolmentInputCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EnrolmentInputCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnrolmentInputCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnrolmentInputCategory[]    findAll()
 * @method EnrolmentInputCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnrolmentInputCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnrolmentInputCategory::class);
    }

    // /**
    //  * @return EnrolmentInputCategory[] Returns an array of EnrolmentInputCategory objects
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
    public function findOneBySomeField($value): ?EnrolmentInputCategory
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
