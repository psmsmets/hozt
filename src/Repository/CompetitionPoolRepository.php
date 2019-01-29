<?php

namespace App\Repository;

use App\Entity\CompetitionPool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetitionPool|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionPool|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionPool[]    findAll()
 * @method CompetitionPool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionPoolRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetitionPool::class);
    }

    // /**
    //  * @return CompetitionPool[] Returns an array of CompetitionPool objects
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
    public function findOneBySomeField($value): ?CompetitionPool
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
