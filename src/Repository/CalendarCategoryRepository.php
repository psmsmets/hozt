<?php

namespace App\Repository;

use App\Entity\CalendarCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CalendarCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalendarCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalendarCategory[]    findAll()
 * @method CalendarCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalendarCategory::class);
    }

    // /**
    //  * @return CalendarCategory[] Returns an array of CalendarCategory objects
    //  */
    public function findAllEnabled()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.sequence', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
