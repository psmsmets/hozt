<?php

namespace App\Repository;

use App\Entity\SpaghettiMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpaghettiMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpaghettiMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpaghettiMenu[]    findAll()
 * @method SpaghettiMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpaghettiMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpaghettiMenu::class);
    }

    // /**
    //  * @return SpaghettiMenu[] Returns an array of SpaghettiMenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SpaghettiMenu
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
