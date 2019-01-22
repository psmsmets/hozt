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
    public function findAllJoinedToTeams()
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.teams', 't')
            ->addSelect('t')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.sequence', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
