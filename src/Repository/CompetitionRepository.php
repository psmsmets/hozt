<?php

namespace App\Repository;

use App\Entity\TrainingTeamCategory;
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
    public function findUpcomingCompetitionEventsByTeamCategory(TrainingTeamCategory $teamCategory)
    {
        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('competition.pool','pool')
            ->leftJoin('competition.documents','docs')
            ->leftJoin('docs.category','docsCat')
            ->leftJoin('competition.teams','teams')
            ->leftJoin('teams.category','teamsCat')
            ->leftJoin('competition.teamCategories','teamCats')
            ->addSelect('competition')
            ->addSelect('event')
            ->addSelect('pool')
            ->addSelect('docs')
            ->addSelect('docsCat')
            ->andWhere('event.enabled = :enabled')
            ->andWhere('( event.endTime >= :today_start or (event.startTime >= :today_end and event.endTime is null) )')
            ->andWhere('(teamCats.id = :teamCategory or teamsCat.id = :teamCategory)')
            ->setParameter('enabled', true)
            ->setParameter('today_start', date("Y-m-d").' 00:00')
            ->setParameter('today_end', date("Y-m-d").' 23:59')
            ->setParameter('teamCategory', $teamCategory->getId())
            ->orderBy('event.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCompetitionResultsByTeamCategory(TrainingTeamCategory $teamCategory, string $slug = 'uitslag')
    {
        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('competition.pool','pool')
            ->leftJoin('competition.documents','docs')
            ->leftJoin('docs.category','docsCat')
            ->leftJoin('competition.teams','teams')
            ->leftJoin('teams.category','teamsCat')
            ->leftJoin('competition.teamCategories','teamCats')
            ->addSelect('competition')
            ->addSelect('event')
            ->addSelect('pool')
            ->addSelect('docs')
            ->addSelect('docsCat')
            ->andWhere('event.enabled = :enabled')
            ->andWhere('event.archived = :archived')
            ->andWhere('docsCat.slug = :slug')
            ->andWhere('(teamCats.id = :teamCategory or teamsCat.id = :teamCategory)')
            ->setParameter('enabled', true)
            ->setParameter('archived', false)
            ->setParameter('teamCategory', $teamCategory->getId())
            ->setParameter('slug', $slug)
            ->orderBy('event.startTime', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
