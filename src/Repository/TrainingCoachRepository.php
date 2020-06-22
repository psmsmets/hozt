<?php

namespace App\Repository;

use App\Entity\TrainingCoach;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrainingCoach|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingCoach|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingCoach[]    findAll()
 * @method TrainingCoach[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingCoachRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingCoach::class);
    }

    // /**
    //  * @return TrainingCoach[] Returns an array of TrainingCoach objects
    //  */
    public function findAllJoinedToTeams(bool $head=true)
    {
        return $this->createQueryBuilder('coach')
            ->innerJoin('coach.teams', 'teams')
            ->addSelect('teams')
            ->andWhere('coach.enabled = :enabled')
            ->andWhere('teams.enabled = :enabled')
            ->andWhere('coach.head = :head')
            ->setParameter('enabled', true)
            ->setParameter('head', $head)
            ->orderBy('coach.firstname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function countEnabled()
    {
        return $this->createQueryBuilder('coach')
            ->select('count(coach.id)')
            ->andWhere('coach.enabled = :enabled')
            ->setParameter('enabled', true)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

}
