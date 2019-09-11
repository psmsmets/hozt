<?php

namespace App\Repository;

use App\Entity\CompetitionEnrolment;
use App\Entity\User;
use App\Entity\Member;
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

}
