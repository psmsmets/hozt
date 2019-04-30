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
    public function findCarouselSlides(bool $admin = false)
    { 
        if ($admin) {
            return $this->createQueryBuilder('carousel')
                //->andWhere('(carousel.publishAt <= :now and carousel.enabled = :enabled) or carousel.publishAt >= :now')
                ->andWhere('(carousel.publishUntil > :now or carousel.publishUntil is null)')
                //->setParameter('enabled', true)
                ->setParameter('now', date("Y-m-d H:i"))
                ->orderBy('carousel.publishAt', 'DESC')
                ->getQuery()
                ->getResult()
            ;

        } else {
            return $this->createQueryBuilder('carousel')
                ->andWhere('carousel.enabled = :enabled')
                ->andWhere('carousel.publishAt <= :now')
                ->andWhere('(carousel.publishUntil > :now or carousel.publishUntil is null)')
                ->setParameter('enabled', true)
                ->setParameter('now', date("Y-m-d H:i"))
                ->orderBy('carousel.publishAt', 'DESC')
                ->getQuery()
                ->getResult()
            ;
        }
    }
}
