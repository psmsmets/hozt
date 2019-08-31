<?php

namespace App\Repository;

use App\Entity\CompetitionPart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CompetitionPart|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionPart|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionPart[]    findAll()
 * @method CompetitionPart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionPartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetitionPart::class);
    }

    // /**
    //  * @return CompetitionPart[] Returns an array of CompetitionPart objects
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
    public function findOneBySomeField($value): ?CompetitionPart
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
