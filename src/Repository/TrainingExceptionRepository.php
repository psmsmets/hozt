<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\TrainingTeamCategory;
use App\Entity\TrainingException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrainingException|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingException|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingException[]    findAll()
 * @method TrainingException[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingExceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingException::class);
    }

    // /**
    //  * @return TrainingException[] Returns an array of TrainingDay objects
    //  */
    public function findAllByTeamCategory(TrainingTeamCategory $teamCategory, int $days=28)
    {
        $reftime = new \DateTimeImmutable('today');

        return $this->createQueryBuilder('exception')
            ->leftJoin('exception.teams', 'exception_teams')
            ->leftJoin('exception_teams.category', 'exception_teams_category')
            ->leftJoin('exception.schedule', 'schedule')
            //->leftJoin('schedule.teams', 'schedule_teams')
            //->leftJoin('schedule_teams.category', 'schedule_teams_category')
            ->addSelect('exception')
            ->andWhere('( exception_teams_category = :category )')
            //->andWhere('( exception_teams_category.id = :id or schedule_teams_category = :id )')
            ->andWhere('exception.startDate <= :start')
            ->andWhere('exception.endDate >= :now')
            ->setParameter('category', $teamCategory)
            ->setParameter('now', $reftime)
            ->setParameter('start', $reftime->modify(sprintf('+%d days', $days)))
            ->orderBy('exception.startDate, exception.endDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAll(int $days=28)
    {
        $reftime = new \DateTimeImmutable('today');

        return $this->createQueryBuilder('exception')
            ->leftJoin('exception.teams', 'teams')
            ->leftJoin('exception.schedule', 'schedule')
            ->addSelect('teams')
            ->addSelect('schedule')
            ->andWhere('exception.startDate <= :start')
            ->andWhere('exception.endDate >= :now')
            ->setParameter('now', $reftime)
            ->setParameter('start', $reftime->modify(sprintf('+%d days', $days)))
            ->orderBy('exception.startDate, exception.endDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllGeneralOnDate(\DateTimeInterface $reftime=null )
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        return $this->createQueryBuilder('exception')
            ->leftJoin('exception.teams', 'teams')
            ->leftJoin('exception.schedule', 'schedule')
            ->addSelect('teams')
            ->andWhere('schedule is null')
            ->andWhere('exception.startDate <= :ref')
            ->andWhere('exception.endDate >= :ref')
            ->setParameter('ref', $reftime)
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAllOnDate(\DateTimeInterface $reftime=null, array $filter_teams = null, User $user = null )
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');

        $query = $this->createQueryBuilder('exception')
            ->leftJoin('exception.teams', 'teams')
            ->leftJoin('exception.schedule', 'schedule')
            ->addSelect('teams')
            ->andWhere('exception.startDate <= :ref')
            ->andWhere('exception.endDate >= :ref')
            ->setParameter('ref', $reftime)
        ;
        if (!is_null($filter_teams) or !empty($filter_teams)) {
            $query->andWhere($query->expr()->in('teams.abbr',$filter_teams));
        }
        if (!is_null($user)) {
            $query
                ->leftJoin('teams.members', 'members')
                ->leftJoin('members.user', 'user')
                ->andWhere('user = :user')
                ->setParameter('user', $user)
            ;
        }
        return $query->getQuery()->getResult();     
    }
}
