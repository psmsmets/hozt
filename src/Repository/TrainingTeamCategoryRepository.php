<?php

namespace App\Repository;

use App\Entity\TrainingTeamCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingTeamCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingTeamCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingTeamCategory[]    findAll()
 * @method TrainingTeamCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingTeamCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingTeamCategory::class);
    }

    // /**
    //  * @return TrainingTeamCategory[] Returns an array of TrainingTeamCategory objects
    //  */
    public function findOneByAbbrJoinedToTeams($abbr)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.teams', 't')
            // selects all the team data to avoid the query
            ->addSelect('t')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('c.abbr = :abbr')
            ->setParameter('enabled', true)
            ->setParameter('abbr', $abbr)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneBySlug($slug)
    {
        return $this->createQueryBuilder('category')
            ->innerJoin('category.teams', 'teams')
            ->leftJoin('teams.coaches', 'coaches')
            ->addSelect('category')
            ->addSelect('teams')
            ->addSelect('coaches')
            ->andWhere('category.slug = :slug')
            ->andWhere('category.enabled = :enabled')
            ->setParameter('slug', $slug)
            ->setParameter('enabled', true)
            ->orderBy('category.sequence, teams.abbr', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneBySlugJoinedToTeamsCoachesSchedule($slug)
    {
        return $this->createQueryBuilder('category')
            ->innerJoin('category.teams', 'teams')
            ->leftJoin('teams.schedule', 'schedule')
            ->leftJoin('schedule.day', 'day')
            ->leftJoin('schedule.time', 'time')
            ->leftJoin('teams.coaches', 'coaches')
            ->addSelect('teams')
            ->addSelect('schedule')
            ->addSelect('time')
            ->addSelect('day')
            ->addSelect('coaches')
            ->andWhere('category.slug = :slug')
            ->andWhere('category.enabled = :enabled')
            ->andWhere('teams.enabled = :enabled')
            ->andWhere('schedule.enabled = :enabled')
            ->andWhere('time.enabled = :enabled')
            //->andWhere('schedule.startDate <= :now')
            ->andWhere('(schedule.endDate > :now or schedule.endDate is null)')
            ->setParameter('slug', $slug)
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('category.sequence, t.abbr', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllEnabled()
    {
        return $this->createQueryBuilder('category')
            ->andWhere('category.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('category.sequence', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllJoinedToTeams()
    {
        return $this->createQueryBuilder('category')
            ->innerJoin('category.teams', 'teams')
            // selects all the team data to avoid the query
            ->addSelect('teams')
            ->andWhere('category.enabled = :enabled')
            ->andWhere('teams.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('category.sequence', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllJoinedToTeamsCoachesSchedule(int $days=28)
    {
        $today = new \DateTime('today');
        return $this->createQueryBuilder('c')
            ->innerJoin('c.teams', 't')
            ->innerJoin('t.schedule', 's')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            // selects all the team data to avoid the query
            ->addSelect('t')
            ->addSelect('s')
            ->addSelect('h')
            ->addSelect('d')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('s.startDate <= :start')
            ->andWhere('(s.endDate >= :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('now', $today->format('Y-m-d'))
            ->setParameter('start', $today->modify('+'.$days.' days')->format('Y-m-d'))
            ->orderBy('c.sequence, t.abbr, d.id, h.startTime', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllJoinedToTeamsCoaches()
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.teams', 't')
            ->innerJoin('t.coaches', 'o')
            // selects all the team data to avoid the query
            ->addSelect('t')
            ->addSelect('o')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.sequence', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllWithPersistentTraining(int $days=28)
    {
        $today = new \DateTime('today');
        return $this->createQueryBuilder('teamsCat')
            ->innerJoin('teamsCat.teams', 'teams')
            ->leftJoin('teams.schedule', 'schedule')
            ->andWhere('schedule.enabled = :enabled')
            ->andWhere('schedule.persistent = :persistent')
            ->andWhere('schedule.startDate <= :start')
            ->andWhere('(schedule.endDate >= :now or schedule.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('persistent', true)
            ->setParameter('now', $today->format('Y-m-d'))
            ->setParameter('start', $today->modify('+'.$days.' days')->format('Y-m-d'))
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllWithTrainingException(int $days=28)
    {
        $today = new \DateTime('today');
        return $this->createQueryBuilder('teamsCat')
            ->innerJoin('teamsCat.teams', 'teams')
            ->leftJoin('teams.exceptions', 'exceptions')
            ->andWhere('exceptions.enabled = :enabled')
            ->andWhere('exceptions.startDate <= :start')
            ->andWhere('exceptions.endDate >= :now')
            ->setParameter('enabled', true)
            ->setParameter('now', $today->format('Y-m-d'))
            ->setParameter('start', $today->modify('+'.$days.' days')->format('Y-m-d'))
            ->getQuery()
            ->getResult()
        ;     
    }


}
