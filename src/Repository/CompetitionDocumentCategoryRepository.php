<?php

namespace App\Repository;

use App\Entity\CompetitionDocumentCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CompetitionDocumentCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionDocumentCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionDocumentCategory[]    findAll()
 * @method CompetitionDocumentCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionDocumentCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetitionDocumentCategory::class);
    }

    // /**
    //  * @return CompetitionDocumentCategory[] Returns an array of CompetitionDocumentCategory objects
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
    public function findOneBySomeField($value): ?CompetitionDocumentCategory
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
