<?php

namespace App\Repository;

use App\Entity\User;
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
    public function findAllJoinedToTeam(int $days=28, \DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        return $this->createQueryBuilder('schedule')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('schedule.time', 'time')
            ->addSelect('teams')
            ->addSelect('time')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('now', $reftime)
            ->setParameter('start', (clone $reftime)->modify(sprintf('+%d days', $days)))
            ->orderBy('schedule.dayNumber, time.startTime, time.duration, teams.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    // /**
    //  * @return TrainingSchedule[] Returns an array of TrainingSchedule objects
    //  */
    public function findAllByUserForPeriod(User $user, \DateTimeInterface $reftime=null, int $days=7 )
    {
        return $this->createQueryBuilder('schedule')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('teams.members', 'members')
            ->innerJoin('members.user', 'user')
            ->innerJoin('schedule.time', 'time')
            ->leftJoin('schedule.exceptions', 'exception')
            ->leftJoin('exception.teams', 'ex_teams')
            ->addSelect('teams')
            ->addSelect('members')
            ->addSelect('time')
            ->addSelect('exception')
            ->addSelect('ex_teams')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :end or schedule.endDate is null)')
            ->andWhere('user = :user')
            ->setParameter('start', $reftime)
            ->setParameter('end', (clone $reftime)->modify(sprintf('+%d days', $days)))
            ->setParameter('user', $user)
            ->orderBy('time.startTime, time.duration, teams.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    // /**
    //  * @return TrainingSchedule[] Returns an array of TrainingSchedule objects
    //  */
    public function findAllOnDate(\DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

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
            ->setParameter('day', date('N', $reftime->getTimestamp()))
            ->setParameter('now', $reftime)
            ->orderBy('time.startTime, time.duration, teams.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllByTeamJoinedToTeam(string $team_abbr, \DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        return $this->createQueryBuilder('schedule')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('schedule.time', 'time')
            ->addSelect('time')
            ->andWhere('teams.abbr = :abbr')
            ->andWhere('schedule.startDate <= :now')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('abbr', $team_abbr)
            ->setParameter('now', $reftime)
            ->orderBy('schedule.dayNumber, time.startTime, time.duration', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllByTeamCategory(TrainingTeamCategory $teamCategory, int $days=28, \DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        return $this->createQueryBuilder('schedule')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('teams.category', 'teamsCat')
            ->innerJoin('schedule.time', 'time')
            ->addSelect('time')
            ->andWhere('teamsCat = :teamCategory')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('teamCategory', $teamCategory)
            ->setParameter('now', $reftime)
            ->orderBy('schedule.dayNumber, time.startTime, time.duration', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function countPersistentByTeamCategory(TrainingTeamCategory $teamCategory, int $days=28, \DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        return $this->createQueryBuilder('schedule')
            ->select('count(schedule.id)')
            ->innerJoin('schedule.teams', 'teams')
            ->innerJoin('teams.category', 'teamsCat')
            ->andWhere('schedule.persistent = :persistent')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->andWhere('teamsCat = :teamCategory')
            ->setParameter('persistent', true)
            ->setParameter('now', $reftime)
            ->setParameter('start', (clone $reftime)->modify(sprintf('+%d days', $days)))
            ->setParameter('teamCategory', $teamCategory)
            ->getQuery()
            ->getSingleScalarResult()
        ;     
    }
    public function countPersistent(int $days=28, \DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        return $this->createQueryBuilder('schedule')
            ->select('count(schedule.id)')
            ->andWhere('schedule.persistent = :persistent')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('persistent', true)
            ->setParameter('now', $reftime)
            ->setParameter('start', (clone $reftime)->modify(sprintf('+%d days', $days)))
            ->getQuery()
            ->getSingleScalarResult()
        ;     
    }

    public function findAllPersistent(int $days=28, \DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        return $this->createQueryBuilder('schedule')
            ->andWhere('schedule.persistent = :persistent')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('persistent', true)
            ->setParameter('now', $reftime)
            ->setParameter('start', (clone $reftime)->modify(sprintf('+%d days', $days)))
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllJoinedToTeams(\DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        return $this->createQueryBuilder('s')
            ->innerJoin('s.time', 'h')
            ->innerJoin('s.teams', 't')
            ->addSelect('h')
            ->addSelect('t')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->setParameter('now', $reftime)
            ->orderBy('s.dayNumber, h.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }
}
