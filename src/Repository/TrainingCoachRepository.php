<?php

namespace App\Repository;

use App\Entity\TrainingCoach;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingCoach|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingCoach|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingCoach[]    findAll()
 * @method TrainingCoach[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingCoachRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
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
}
