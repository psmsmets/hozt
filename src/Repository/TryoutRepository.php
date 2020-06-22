<?php

namespace App\Repository;

use App\Entity\Tryout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tryout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tryout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tryout[]    findAll()
 * @method Tryout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TryoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tryout::class);
    }

    public function findTryout(string $uuid)
    {
        return $this->createQueryBuilder('tryout')
            ->where('tryout.enabled = :enabled')
            ->andwhere('tryout.uuid = :uuid')
            ->setParameter('enabled', true)
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult() 
        ;     
    }

    public function findTryouts(int $pastdays = 0)
    {
        $now = new \DateTime('now');
        $old = new \DateTime("today midnight -$pastdays days");

        return $this->createQueryBuilder('tryout')
            ->where('tryout.enabled = :enabled')
            ->andwhere('tryout.publishAt < :ref')
            ->andwhere('tryout.startTime > :end')
            ->setParameter('enabled', true)
            ->setParameter('ref', $now)
            ->setParameter('end', $old)
            ->orderBy('tryout.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function countActiveTryouts()
    {
        $now = new \DateTime('now');
        $old = new \DateTime('today midnight -0 days');

        return $this->createQueryBuilder('tryout')
            ->select('count(tryout.id)')
            ->where('tryout.enabled = :enabled')
            ->andwhere('tryout.publishAt < :ref')
            ->andwhere('tryout.startTime > :end')
            ->setParameter('enabled', true)
            ->setParameter('ref', $now)
            ->setParameter('end', $old)
            ->getQuery()
            ->getSingleScalarResult()
        ;    
    }

    public function flush()
    {
        $this->_em->flush();
    }

}
