<?php

namespace App\Repository;

use App\Entity\CompetitionEnrolment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetitionEnrolment|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionEnrolment|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionEnrolment[]    findAll()
 * @method CompetitionEnrolment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionEnrolmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetitionEnrolment::class);
    }

    // /**
    //  * @return CompetitionEnrolment[] Returns an array of CompetitionEnrolment objects
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
    public function findOneBySomeField($value): ?CompetitionEnrolment
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
