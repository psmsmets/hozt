<?php

namespace App\Repository;

use App\Entity\TrainingSchedule;
use App\Entity\TrainingTeam;
use App\Entity\TrainingTeamCategory;
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
    public function findAllJoinedToTeam(int $days=28, \DateTime $refdate = null)
    {
        if (is_null($refdate)) $refdate = new \DateTime('today midnight');
        return $this->createQueryBuilder('schedule')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('schedule.time', 'time')
            ->addSelect('teams')
            ->addSelect('time')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('now', $refdate->format('Y-m-d'))
            ->setParameter('start', $refdate->modify('+'.$days.' days')->format('Y-m-d'))
            ->orderBy('schedule.dayNumber, time.startTime, time.duration, teams.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }


    // /**
    //  * @return TrainingSchedule[] Returns an array of TrainingSchedule objects
    //  */
    public function findAllOnDate(\DateTime $refdate = null)
    {
        if (is_null($refdate)) $refdate = new \DateTime('today midnight');
        return $this->createQueryBuilder('schedule')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('schedule.time', 'time')
            ->leftJoin('schedule.exceptions', 'exception')
            ->leftJoin('exception.teams', 'ex_teams')
            ->addSelect('teams')
            ->addSelect('time')
            ->addSelect('exception')
            ->addSelect('ex_teams')
            ->andWhere('schedule.dayNumber = :day')
            ->andWhere('schedule.startDate <= :now')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('day', date('N', $refdate->getTimestamp()))
            ->setParameter('now', $refdate->format("Y-m-d"))
            ->orderBy('time.startTime, time.duration, teams.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllByTeamJoinedToTeam(string $team_abbr, \DateTime $refdate = null)
    {
        if (is_null($refdate)) $refdate = new \DateTime('today midnight');
        return $this->createQueryBuilder('schedule')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('schedule.time', 'time')
            ->addSelect('time')
            ->andWhere('teams.abbr = :abbr')
            ->andWhere('schedule.startDate <= :now')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('abbr', $team_abbr)
            ->setParameter('now', $refdate->format("Y-m-d"))
            ->orderBy('schedule.dayNumber, time.startTime, time.duration', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllByTeamCategory(TrainingTeamCategory $teamCategory, int $days=28, \DateTime $refdate = null)
    {
        if (is_null($refdate)) $refdate = new \DateTime('today midnight');
        return $this->createQueryBuilder('schedule')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('teams.category', 'teamsCat')
            ->innerJoin('schedule.time', 'time')
            ->addSelect('time')
            ->andWhere('teamsCat.id = :id')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('id', $teamCategory->getId())
            ->setParameter('now', $refdate->format("Y-m-d"))
            ->orderBy('schedule.dayNumber, time.startTime, time.duration', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function countPersistentByTeamCategory(TrainingTeamCategory $teamCategory, int $days=28, \DateTime $refdate = null)
    {
        if (is_null($refdate)) $refdate = new \DateTime('today midnight');
        return $this->createQueryBuilder('schedule')
            ->select('count(schedule.id)')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('teams.category', 'teamsCat')
            ->andWhere('schedule.persistent = :persistent')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->andWhere('teamsCat.id = :id')
            ->setParameter('persistent', true)
            ->setParameter('now', $refdate->format('Y-m-d'))
            ->setParameter('start', $refdate->modify('+'.$days.' days')->format('Y-m-d'))
            ->setParameter('id', $teamCategory->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;     
    }
    public function countPersistent(int $days=28, \DateTime $refdate = null)
    {
        if (is_null($refdate)) $refdate = new \DateTime('today midnight');
        return $this->createQueryBuilder('schedule')
            ->select('count(schedule.id)')
            ->andWhere('schedule.persistent = :persistent')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('persistent', true)
            ->setParameter('now', $refdate->format('Y-m-d'))
            ->setParameter('start', $refdate->modify('+'.$days.' days')->format('Y-m-d'))
            ->getQuery()
            ->getSingleScalarResult()
        ;     
    }

    public function findAllPersistent(int $days=28, \DateTime $refdate = null)
    {
        if (is_null($refdate)) $refdate = new \DateTime('today midnight');
        return $this->createQueryBuilder('schedule')
            ->andWhere('schedule.persistent = :persistent')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('persistent', true)
            ->setParameter('now', $refdate->format('Y-m-d'))
            ->setParameter('start', $refdate->modify('+'.$days.' days')->format('Y-m-d'))
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllJoinedToTeams(\DateTime $refdate = null)
    {
        if (is_null($refdate)) $refdate = new \DateTime('today midnight');
        return $this->createQueryBuilder('s')
            ->innerJoin('s.time', 'h')
            ->innerJoin('s.teams', 't')
            ->addSelect('h')
            ->addSelect('t')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->setParameter('now', $refdate->format('Y-m-d'))
            ->orderBy('s.dayNumber, h.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }
}
