<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\TrainingSchedule;
use App\Entity\TrainingTeam;
use App\Entity\TrainingTeamCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrainingSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingSchedule[]    findAll()
 * @method TrainingSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
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
    public function findAllOnDate(\DateTimeInterface $reftime=null, array $filter_teams = null, User $user = null)
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        $query = $this->createQueryBuilder('schedule')
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
        ;
        if (!is_null($filter_teams) or !empty($filter_teams)) {
            $query->andWhere($query->expr()->in('teams.abbr',$filter_teams));
        }
        if (!is_null($user)) {
            $query
                ->leftJoin('teams.members', 'members')
                ->leftJoin('members.user', 'user')
                ->andWhere('user = :user')
                ->setParameter('user', $user)
            ;
        }
        return $query->getQuery()->getResult();     
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
            ->andWhere('schedule.persistent = :persistent')
            ->andWhere('teamsCat = :teamCategory')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('persistent', false)
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
