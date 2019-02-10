<?php

namespace App\Repository;

use App\Entity\TrainingSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingSchedule[]    findAll()
 * @method TrainingSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingScheduleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingSchedule::class);
    }

    // /**
    //  * @return TrainingSchedule[] Returns an array of TrainingSchedule objects
    //  */
    public function findAllByDayJoinedToTeam(int $day)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.teams', 't')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            ->addSelect('t')
            //->addSelect('d')
            ->addSelect('h')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('d.id = :day')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate >= :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('day', $day)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('h.startTime, h.endTime, t.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllByTeamJoinedToTeam(string $team_abbr)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.teams', 't')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            //->addSelect('t')
            ->addSelect('d')
            ->addSelect('h')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('t.abbr = :abbr')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate >= :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('abbr', $team_abbr)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('d.id, h.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllByTeamCategory(int $team_category)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.teams', 't')
            ->innerJoin('t.category', 'c')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            ->addSelect('d')
            ->addSelect('h')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('c.id = :id')
            ->andWhere('(s.endDate >= :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('id', $team_category)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('d.id, h.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }
/*
    public function findAllSchedules()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.enabled = :enabled')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            ->addSelect('t')
            ->addSelect('d')
            ->addSelect('h')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('t.startDate <= :now')
            ->andWhere('(t.endDate > :now or t.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('d.id, h.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }
*/

    public function findAllJoinedToTeams()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.enabled = :enabled')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            ->innerJoin('s.teams', 't')
            ->addSelect('d')
            ->addSelect('h')
            ->addSelect('t')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('d.id, h.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }
}
