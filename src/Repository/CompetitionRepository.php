<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\TrainingTeam;
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
        $reftime = new \DateTime('today');

        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('competition.pool','pool')
            ->leftJoin('competition.documents','docs')
            ->leftJoin('docs.category','docsCat')
            ->leftJoin('competition.teams','teams')
            ->leftJoin('teams.category','teamsCat')
            ->addSelect('competition')
            ->addSelect('event')
            ->addSelect('pool')
            ->addSelect('docs')
            ->addSelect('docsCat')
            ->andWhere('( event.endTime >= :reftime or (event.startTime >= :reftime and event.endTime is null) )')
            ->andWhere('teamsCat.id = :teamCategory')
            ->setParameter('reftime', $reftime)
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
            ->addSelect('competition')
            ->addSelect('event')
            ->addSelect('pool')
            ->addSelect('docs')
            ->addSelect('docsCat')
            ->andWhere('docsCat.slug = :slug')
            ->andWhere('teamsCat.id = :teamCategory')
            ->setParameter('teamCategory', $teamCategory->getId())
            ->setParameter('slug', $slug)
            ->orderBy('event.startTime', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCompetition(int $id)
    {
        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('competition.pool','pool')
            ->leftJoin('competition.teams','teams')
            ->leftJoin('competition.competitionParts','competitionParts')
            #->leftJoin('competitionParts.enrolments','enrolments')
            #->leftJoin('enrolments.competitor','competitor')
            ->addSelect('competition')
            ->addSelect('competitionParts')
            ->addSelect('event')
            ->addSelect('pool')
            ->addSelect('teams')
            #->addSelect('enrolments')
            #->addSelect('competitor')
            ->andWhere('competition.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function findCompetitions(\DateTimeInterface $periodStart, \DateTimeInterface $periodEnd)
    {
        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('competition.pool','pool')
            ->innerJoin('competition.competitionParts','competitionParts')
            ->addSelect('competition')
            ->addSelect('competitionParts')
            ->addSelect('event')
            ->addSelect('pool')
            ->andWhere('( event.startTime >= :start and event.startTime < :end and (event.endTime < :end or event.endTime is null) )')
            ->setParameter('start', $periodStart)
            ->setParameter('end', $periodEnd)
            ->orderBy('event.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingCompetitions(\DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTime('today');

        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('competition.competitionParts','competitionParts')
            ->addSelect('competition')
            ->addSelect('event')
            ->addSelect('competitionParts')
            ->andWhere('( event.endTime >= :reftime or (event.startTime >= :reftime and event.endTime is null) )')
            ->setParameter('reftime', $reftime)
            ->orderBy('event.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCompetitionsByUser(User $user, \DateTimeInterface $periodStart, \DateTimeInterface $periodEnd)
    {
        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('competition.pool','pool')
            ->innerJoin('competition.competitionParts','competitionParts')
            ->innerJoin('competitionParts.enrolments','enrolments')
            ->innerJoin('enrolments.competitor', 'competitor')
            ->innerJoin('competitor.user', 'user')
            ->addSelect('competition')
            ->addSelect('competitionParts')
            ->addSelect('event')
            ->addSelect('pool')
            ->andWhere('( event.startTime >= :start and event.startTime < :end and (event.endTime < :end or event.endTime is null) )')
            ->andWhere('user = :user')
            ->andWhere('enrolments.filtered = true')
            ->setParameter('start', $periodStart)
            ->setParameter('end', $periodEnd)
            ->setParameter('user', $user)
            ->orderBy('event.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findNewCompetitionsByUser(User $user, \DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTime('today');

        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('competition.competitionParts','competitionParts')
            ->innerJoin('competitionParts.enrolments','enrolments')
            ->innerJoin('enrolments.competitor', 'competitor')
            ->innerJoin('competitor.user', 'user')
            ->addSelect('competition')
            //->addSelect('competitionParts')
            ->addSelect('event')
            ->andWhere('( event.endTime >= :reftime or (event.startTime >= :reftime and event.endTime is null) )')
            ->andWhere('competition.enrolBefore > :reftime')
            ->andWhere('user = :user')
            ->andWhere('enrolments.enrolledAt is null')
            ->andWhere('enrolments.filtered = true')
            ->setParameter('reftime', $reftime)
            ->setParameter('user', $user)
            ->orderBy('event.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingCompetitionsByUser(User $user, \DateTimeInterface $reftime=null)
    {
        if (is_null($reftime)) $reftime = new \DateTime('today');

        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('competition.competitionParts','competitionParts')
            ->innerJoin('competitionParts.enrolments','enrolments')
            ->innerJoin('enrolments.competitor', 'competitor')
            ->innerJoin('competitor.user', 'user')
            ->addSelect('competition')
            //->addSelect('competitionParts')
            ->addSelect('event')
            ->andWhere('( event.endTime >= :reftime or (event.startTime >= :reftime and event.endTime is null) )')
            ->andWhere('user = :user')
            ->andWhere('enrolments.enrolled = true')
            ->andWhere('enrolments.filtered = true')
            ->setParameter('reftime', $reftime)
            ->setParameter('user', $user)
            ->orderBy('event.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingCompetitionsByTeam(TrainingTeam $team, int $days=5)
    {
        $reftime = new \DateTime(sprintf("today +%d days", abs($days)));

        return $this->createQueryBuilder('competition')
            ->innerJoin('competition.competitionParts','competitionParts')
            ->innerJoin('competition.teams','teams')
            ->addSelect('competition')
            ->addSelect('competitionParts')
            ->addSelect('teams')
            ->andWhere('teams.id = :team')
            ->andWhere('competition.enrolBefore >= :reftime')
            ->setParameter('reftime', $reftime)
            ->setParameter('team', $team->getId())
            ->orderBy('competition.enrolBefore', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function flush()
    {
        $this->_em->flush();
    }

}
