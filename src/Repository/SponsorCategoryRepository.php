<?php

namespace App\Repository;

use App\Entity\SponsorCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SponsorCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SponsorCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SponsorCategory[]    findAll()
 * @method SponsorCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SponsorCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SponsorCategory::class);
    }

    // /**
    //  * @return SponsorCategory[] Returns an array of SponsorCategory objects
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
    public function findOneBySomeField($value): ?SponsorCategory
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
