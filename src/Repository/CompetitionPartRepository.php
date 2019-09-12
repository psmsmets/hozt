<?php

namespace App\Repository;

use App\Entity\CalendarEvent;
use App\Entity\CompetitionPart;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CompetitionPart|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionPart|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionPart[]    findAll()
 * @method CompetitionPart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionPartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetitionPart::class);
    }

    public function findUserCompetitionPartsByEvent(User $user, CalendarEvent $event)
    {
        return $this->createQueryBuilder('competitionPart')
            ->leftJoin('competitionPart.enrolments','enrolments')
            ->innerJoin('competitionPart.competition','competition')
            ->innerJoin('competition.calendar','event')
            ->innerJoin('enrolments.member', 'members')
            ->innerJoin('members.user', 'user')
            ->addSelect('enrolments')
            ->addSelect('members')
            ->addSelect('competitionPart')
            ->andWhere('event = :event')
            ->andWhere('user = :user')
            ->setParameter('event', $event)
            ->setParameter('user', $user)
            ->orderBy('members.birthdate', 'DESC')
            ->orderBy('competitionPart.daypart', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
