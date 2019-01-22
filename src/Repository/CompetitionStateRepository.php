<?php

namespace App\Repository;

use App\Entity\CompetitionState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetitionState|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionState|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionState[]    findAll()
 * @method CompetitionState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionStateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetitionState::class);
    }

    // /**
    //  * @return CompetitionState[] Returns an array of CompetitionState objects
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
    public function findOneBySomeField($value): ?CompetitionState
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
