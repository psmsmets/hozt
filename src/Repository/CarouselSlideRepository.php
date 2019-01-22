<?php

namespace App\Repository;

use App\Entity\CarouselSlide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CarouselSlide|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarouselSlide|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarouselSlide[]    findAll()
 * @method CarouselSlide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarouselSlideRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarouselSlide::class);
    }

    // /**
    //  * @return CarouselSlide[] Returns an array of CarouselSlide objects
    //  */
    public function findCarouselSlides()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('c.publishAt <= :now')
            ->andWhere('(c.publishUntil > :now or c.publishUntil is null)')
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d H:i"))
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
