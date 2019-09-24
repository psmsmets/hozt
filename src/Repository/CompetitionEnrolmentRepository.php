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
            ->innerJoin('enrolments.member', 'members')
            ->innerJoin('members.user', 'user')
            ->addSelect('enrolments')
            ->addSelect('members')
            ->addSelect('competitionPart')
            ->andWhere('( event.startTime >= :start and event.startTime < :end and (event.endTime < :end or event.endTime is null) )')
            ->andWhere('user = :user')
            ->setParameter('start', $periodStart->format('Y-m-d'))
            ->setParameter('end', $periodEnd->format('Y-m-d'))
            ->setParameter('user', $user)
            ->orderBy('members.birthdate', 'DESC')
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
            ->innerJoin('enrolments.member', 'members')
            ->addSelect('enrolments')
            ->addSelect('members')
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
            ->innerJoin('enrolment.member', 'members')
            ->innerJoin('members.user', 'user')
            ->andWhere('user = :user')
            ->andWhere('competitionPart.id = :competitionPartId')
            ->andWhere('members.id = :memberId')
            ->setParameter('user', $user)
            ->setParameter('competitionPartId', $competitionPartId)
            ->setParameter('memberId', $memberId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findUpcomingMemberCompetitionEnrolments(Member $member, int $days=14)
    {
        $reftime = new \DateTime(sprintf("today +%d days", abs($days)));

        return $this->createQueryBuilder('enrolment')
            ->innerJoin('enrolment.competitionPart','competitionPart')
            ->innerJoin('competitionPart.competition','competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('enrolment.member', 'membr')
            ->andWhere('membr = :membr')
            ->andWhere('( event.endTime >= :reftime or (event.startTime >= :reftime and event.endTime is null) )')
            ->setParameter('membr', $member)
            ->setParameter('reftime', $reftime)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingMemberCompetitionEnrolmentsNotTeam(Member $member, TrainingTeam $team, int $days=14)
    {
        $reftime = new \DateTime(sprintf("today +%d days", abs($days)));

        return $this->createQueryBuilder('enrolment')
            ->innerJoin('enrolment.competitionPart','competitionPart')
            ->innerJoin('competitionPart.competition','competition')
            ->innerJoin('competition.teams','teams')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('enrolment.member', 'membr')
            ->addSelect('competitionPart')
            ->addSelect('competition')
            ->addSelect('teams')
            ->andWhere('membr = :membr')
            ->andWhere('teams.id <> :team')
            ->andWhere('( event.endTime >= :reftime or (event.startTime >= :reftime and event.endTime is null) )')
            ->setParameter('membr', $member)
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
