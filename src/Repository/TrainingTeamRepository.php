<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\TrainingTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrainingTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingTeam[]    findAll()
 * @method TrainingTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingTeam::class);
    }

    public function findAllJoinedToCoachesAndSchedule()
    {
        $reftime = new \DateTime('today');

        return $this->createQueryBuilder('t')
            ->innerJoin('t.coaches', 'c')
            ->innerJoin('t.schedule', 's')
            ->innerJoin('s.day', 'd')
            ->innerJoin('s.time', 'h')
            // selects all the team data to avoid the query
            ->addSelect('s')
            ->addSelect('d')
            ->addSelect('h')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('h.enabled = :enabled')
            ->andWhere('s.startDate <= :now')
            ->andWhere('(s.endDate > :now or s.endDate is null)')
            ->setParameter('enabled', true)
            ->setParameter('now', $reftime)
            ->orderBy('d.id, s.start_time', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getEnabled()
    {
        return $this->createQueryBuilder('team')
            ->andWhere('team.enabled = :enabled')
            ->setParameter('enabled', true)
            //->orderBy('team.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getByUser(User $user)
    {
        return $this->createQueryBuilder('team')
            ->innerJoin('team.members', 'members')
            ->innerJoin('members.user', 'user')
            ->andWhere('team.enabled = :enabled')
            ->andWhere('user = :user')
            ->setParameter('enabled', true)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getDefaultEnrolled()
    {
        return $this->createQueryBuilder('team')
            ->andWhere('team.enabled = :enabled')
            ->andWhere('team.defaultEnrolled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('team.abbr', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countEnabled()
    {
        return $this->createQueryBuilder('team')
            ->select('count(team.id)')
            ->andWhere('team.enabled = :enabled')
            ->setParameter('enabled', true)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function countDisabled()
    {
        return $this->createQueryBuilder('team')
            ->select('count(team.id)')
            ->andWhere('team.enabled = :enabled')
            ->setParameter('enabled', false)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function flush()
    {
        $this->_em->flush();
    }

}
