<?php

namespace App\Repository;

use App\Entity\Competition;
use App\Entity\CompetitionEnrolment;
use App\Entity\User;
use App\Entity\Member;
use App\Entity\TrainingTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetitionEnrolment|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionEnrolment|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionEnrolment[]    findAll()
 * @method CompetitionEnrolment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionEnrolmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetitionEnrolment::class);
    }

    public function findCompetitionEnrolmentsByUser(User $user, \DateTimeInterface $periodStart, \DateTimeInterface $periodEnd)
    {
        return $this->createQueryBuilder('enrolments')
            ->innerJoin('enrolments.competitionPart','competitionPart')
            ->innerJoin('competitionPart.competition','competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('enrolments.competitor', 'competitor')
            ->innerJoin('competitor.user', 'user')
            ->addSelect('enrolments')
            ->addSelect('competitor')
            ->addSelect('competitionPart')
            ->andWhere('event.cancelled = false')
            ->andWhere('( event.startTime >= :start and event.startTime < :end and (event.endTime < :end or event.endTime is null) )')
            ->andWhere('user = :user')
            ->setParameter('start', $periodStart)
            ->setParameter('end', $periodEnd)
            ->setParameter('user', $user)
            ->orderBy('competitor.birthdate', 'DESC')
            ->orderBy('competitionPart.daypart', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCompetitionEnrolments(Competition $competition)
    {
        return $this->createQueryBuilder('enrolments')
            ->innerJoin('enrolments.competitionPart','competitionPart')
            ->innerJoin('competitionPart.competition','competition')
            ->innerJoin('enrolments.competitor', 'competitor')
            ->addSelect('enrolments')
            ->addSelect('competitor')
            ->addSelect('competitionPart')
            ->andWhere('competition = :competition')
            ->setParameter('competition', $competition)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUserCompetitionEnrolment(User $user, int $competitionPartId, int $memberId)
    {
        return $this->createQueryBuilder('enrolment')
            ->innerJoin('enrolment.competitionPart','competitionPart')
            ->innerJoin('enrolment.competitor', 'competitor')
            ->innerJoin('competitor.user', 'user')
            ->andWhere('user = :user')
            ->andWhere('competitionPart.id = :competitionPartId')
            ->andWhere('competitor.id = :memberId')
            ->setParameter('user', $user)
            ->setParameter('competitionPartId', $competitionPartId)
            ->setParameter('memberId', $memberId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findUpcomingMemberCompetitionEnrolments(Member $member, int $days=5)
    {
        $reftime = new \DateTime(sprintf("today +%d days", abs($days)));

        return $this->createQueryBuilder('enrolment')
            ->innerJoin('enrolment.competitionPart','competitionPart')
            ->innerJoin('competitionPart.competition','competition')
            ->innerJoin('enrolment.competitor', 'competitor')
            ->addSelect('competitionPart')
            ->addSelect('competition')
            ->andWhere('competitor = :member')
            ->andWhere('competition.enrolBefore >= :reftime')
            ->setParameter('competitor', $member)
            ->setParameter('reftime', $reftime)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingMemberCompetitionEnrolmentsNotTeam(Member $member, TrainingTeam $team, int $days=5)
    {
        $reftime = new \DateTime(sprintf("today +%d days", abs($days)));

        return $this->createQueryBuilder('enrolment')
            ->innerJoin('enrolment.competitionPart','competitionPart')
            ->innerJoin('competitionPart.competition','competition')
            ->innerJoin('competition.teams','teams')
            ->innerJoin('enrolment.competitor', 'competitor')
            ->addSelect('competitionPart')
            ->addSelect('competition')
            ->andWhere('competitor = :member')
            ->andWhere('teams.id <> :team')
            ->andWhere('competition.enrolBefore >= :reftime')
            ->setParameter('member', $member)
            ->setParameter('team', $team->getId())
            ->setParameter('reftime', $reftime)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPastIrrelevantCompetitionEnrolments(int $days=7)
    {
        $reftime = new \DateTime(sprintf("today midnight -%d days", abs($days)));

        return $this->createQueryBuilder('enrolment')
            ->innerJoin('enrolment.competitionPart','competitionPart')
            ->innerJoin('competitionPart.competition','competition')
            ->innerJoin('competition.calendar','event')
            ->andWhere('( event.endTime < :reftime or (event.startTime < :reftime and event.endTime is null) )')
            ->andWhere('enrolment.filtered = :filtered or (enrolment.restrictions = :restrictions and enrolment.qualified = :qualified)')
            ->setParameter('reftime', $reftime)
            ->setParameter('filtered', false)
            ->setParameter('restrictions', true)
            ->setParameter('qualified', false)
            ->getQuery()
            ->getResult()
        ;
    }

    public function flush()
    {
        $this->_em->flush();
    }

}
