<?php

namespace App\Repository;

use App\Entity\Tryout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tryout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tryout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tryout[]    findAll()
 * @method Tryout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TryoutRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tryout::class);
    }

    public function findTryouts()
    {
        $now = new \DateTime('now');
        return $this->createQueryBuilder('tryout')
            ->where('tryout.enabled = :enabled')
            ->andwhere('tryout.startTime >= :today')
            ->andwhere('tryout.publishAt < :now')
            ->setParameter('enabled', true)
            ->setParameter('today', $now->format('Y-m-d').' 23:59')
            ->setParameter('now', $now->format('Y-m-d H:i'))
            ->orderBy('tryout.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function flush()
    {
        $this->_em->flush();
    }

}
