<?php

namespace App\Repository;

use App\Entity\TrainingDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingDay[]    findAll()
 * @method TrainingDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingDayRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingDay::class);
    }

    // /**
    //  * @return TrainingDay[] Returns an array of TrainingDay objects
    //  */
    public function findAllJoinedToScheduleTeams()
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.schedule', 's')
            ->innerJoin('s.time', 'h')
            ->innerJoin('s.teams', 't')
            ->addSelect('d')
            ->addSelect('h')
            ->addSelect('t')
            ->addSelect('s')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('s.enabled = :enabled')
            //->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('d.id, h.startTime, t.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllByTeamCategoryJoinedToSchedule(int $team_category)
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.schedule', 's')
            ->innerJoin('s.time', 'h')
            ->innerJoin('s.teams', 't')
            ->innerJoin('t.category', 'c')
            ->addSelect('h')
            ->addSelect('s')
            ->addSelect('t')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->andWhere('c.id = :id')
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d"))
            ->setParameter('id', $team_category)
            ->orderBy('d.id, h.startTime, t.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllByTeamJoinedToSchedule(string $team)
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.schedule', 's')
            ->innerJoin('s.time', 'h')
            ->addSelect('h')
            ->addSelect('s')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('s.team = :team')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d"))
            ->setParameter('team', $team)
            ->orderBy('d.id, h.startTime, t.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }
}
