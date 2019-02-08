<?php

namespace App\Repository;

use App\Entity\TrainingScheduleException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingScheduleException|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingScheduleException|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingScheduleException[]    findAll()
 * @method TrainingScheduleException[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingScheduleExceptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingScheduleException::class);
    }

    // /**
    //  * @return TrainingScheduleException[] Returns an array of TrainingScheduleException objects
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
    public function findOneBySomeField($value): ?TrainingScheduleException
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
