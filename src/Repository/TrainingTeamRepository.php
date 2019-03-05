<?php

namespace App\Repository;

use App\Entity\TrainingTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingTeam[]    findAll()
 * @method TrainingTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingTeamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingTeam::class);
    }

    // /**
    //  * @return TrainingTeam[] Returns an array of TrainingTeam objects
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

    public function findAllJoinedToCoachesAndSchedule()
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.coaches', 'c')
            ->innerJoin('t.schedule', 's')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            // selects all the team data to avoid the query
            ->addSelect('s')
            ->addSelect('d')
            ->addSelect('h')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('d.id, s.start_time', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getEnabled()
    {
        return $this->createQueryBuilder('team')
            ->andWhere('team.enabled = :enabled')
            ->setParameter('enabled', true)
            //->orderBy('t.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countEnabled()
    {
        return $this->createQueryBuilder('team')
            ->select('count(team.id)')
            ->andWhere('team.enabled = :enabled')
            ->setParameter('enabled', true)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

}
