<?php

namespace App\Repository;

use App\Entity\Tryout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tryout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tryout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tryout[]    findAll()
 * @method Tryout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TryoutRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tryout::class);
    }

    // /**
    //  * @return Tryout[] Returns an array of Tryout objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tryout
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
