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
            ->andwhere('tryout.publishAt < :ref')
            ->setParameter('enabled', true)
            ->setParameter('ref', $now->format('Y-m-d H:i'))
            ->orderBy('tryout.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function tryoutsAndEnrolments()
    {
        return $this->createQueryBuilder('tryout')
            ->leftJoin('tryout.enrolments','enrolments')
            ->addSelect('enrolments')
            ->where('tryout.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('tryout.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function countActiveTryouts()
    {
        $now = new \DateTime('now');
        return $this->createQueryBuilder('tryout')
            ->select('count(tryout.id)')
            ->where('tryout.enabled = :enabled')
            ->andwhere('tryout.publishAt < :ref')
            ->setParameter('enabled', true)
            ->setParameter('ref', $now->format('Y-m-d H:i'))
            ->getQuery()
            ->getSingleScalarResult()
        ;    
    }

    public function flush()
    {
        $this->_em->flush();
    }

}
