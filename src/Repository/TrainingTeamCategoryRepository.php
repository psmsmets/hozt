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

    public function findOneBySlugJoinedToTeamsCoaches($slug)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.teams', 't')
            ->innerJoin('t.coaches', 'o')
            ->addSelect('t')
            ->addSelect('o')
            ->andWhere('c.slug = :slug')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('slug', $slug)
            ->setParameter('enabled', true)
            ->orderBy('c.sequence, t.abbr', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneBySlugJoinedToTeamsCoachesSchedule($slug)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.teams', 't')
            ->innerJoin('t.schedule', 's')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            ->innerJoin('t.coaches', 'o')
            ->addSelect('t')
            ->addSelect('s')
            ->addSelect('h')
            ->addSelect('d')
            ->addSelect('o')
            ->andWhere('c.slug = :slug')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('o.enabled = :enabled')
            //->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->setParameter('slug', $slug)
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('c.sequence, t.abbr', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllEnabled()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.sequence', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllJoinedToTeams()
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.teams', 't')
            // selects all the team data to avoid the query
            ->addSelect('t')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.sequence', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllJoinedToTeamsCoachesSchedule()
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.teams', 't')
            ->innerJoin('t.schedule', 's')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            ->innerJoin('t.coaches', 'o')
            // selects all the team data to avoid the query
            ->addSelect('t')
            ->addSelect('s')
            ->addSelect('h')
            ->addSelect('d')
            ->addSelect('o')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('o.enabled = :enabled')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d"))
            ->orderBy('c.sequence, t.abbr', 'ASC')
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

}
