<?php

namespace App\Repository;

use App\Entity\BlogCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BlogCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogCategory[]    findAll()
 * @method BlogCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogCategory::class);
    }

    // /**
    //  * @return BlogCategory[] Returns an array of BlogCategory objects
    //  */
    public function findAllEnabled()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.enabled = :enabled')
            ->setParameter('enabled', true)
            //->orderBy('c.sequence', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
