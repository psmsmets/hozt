<?php

namespace App\Repository;

use App\Entity\Competition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Competition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competition[]    findAll()
 * @method Competition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Competition::class);
    }

    // /**
    //  * @return Competition[] Returns an array of Competition objects
    //  */
    public function findUpcomingCompetitionEventsByTeamCategory(int $teamCategory)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.calendar','e')
            ->innerJoin('n.pool','p')
            ->leftJoin('n.teams','t')
            ->leftJoin('t.category','tc')
            ->leftJoin('n.teamCategories','c')
            ->addSelect('e')
            ->addSelect('p')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('e.archived = :archived')
            ->andWhere('( e.endTime >= :today_start or (e.startTime >= :today_end and e.endTime is null) )')
            ->andWhere('(tc.id = :teamCategory or c.id = :teamCategory)')
            ->setParameter('enabled', true)
            ->setParameter('archived', false)
            ->setParameter('today_start', date("Y-m-d").' 00:00')
            ->setParameter('today_end', date("Y-m-d").' 23:59')
            ->setParameter('teamCategory', $teamCategory)
            ->orderBy('e.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingCompetitionPrograms(int $limit = 5)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.calendar','e')
            ->innerJoin('n.pool','p')
            ->addSelect('n')
            ->addSelect('e')
            ->addSelect('p')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('( e.endTime >= :today_start or (e.startTime >= :today_end and e.endTime is null) )')
            ->andWhere('n.program is not null')
            ->setParameter('enabled', true)
            ->setParameter('today_start', date("Y-m-d").' 00:00')
            ->setParameter('today_end', date("Y-m-d").' 23:59')
            ->orderBy('e.startTime', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCompetitionResultsByTeamCategory(int $teamCategory)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.calendar','e')
            ->innerJoin('n.pool','p')
            ->leftJoin('n.teams','t')
            ->leftJoin('t.category','tc')
            ->leftJoin('n.teamCategories','c')
            ->addSelect('n')
            ->addSelect('e')
            ->addSelect('p')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('n.results is not null')
            ->andWhere('(tc.id = :teamCategory or c.id = :teamCategory)')
            ->setParameter('enabled', true)
            ->setParameter('teamCategory', $teamCategory)
            ->orderBy('e.startTime', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLatestCompetitionResults(int $limit = 5)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.calendar','e')
            ->innerJoin('n.pool','p')
            ->addSelect('n')
            ->addSelect('e')
            ->addSelect('p')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('n.results is not null')
            ->setParameter('enabled', true)
            ->orderBy('e.startTime', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

}
