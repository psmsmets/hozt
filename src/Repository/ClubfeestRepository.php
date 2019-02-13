<?php

namespace App\Repository;

use App\Entity\Clubfeest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Clubfeest|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clubfeest|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clubfeest[]    findAll()
 * @method Clubfeest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClubfeestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clubfeest::class);
    }

    // /**
    //  * @return Clubfeest[] Returns an array of Clubfeest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Clubfeest
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
