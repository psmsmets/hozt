<?php

namespace App\Repository;

use App\Entity\TryoutEnrolment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TryoutEnrolment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TryoutEnrolment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TryoutEnrolment[]    findAll()
 * @method TryoutEnrolment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TryoutEnrolmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TryoutEnrolment::class);
    }

    // /**
    //  * @return TryoutEnrolment[] Returns an array of TryoutEnrolment objects
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
    public function findOneBySomeField($value): ?TryoutEnrolment
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
