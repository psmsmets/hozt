<?php

namespace App\Repository;

use App\Entity\TrainingTeamCategory;
use App\Entity\TrainingException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingException|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingException|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingException[]    findAll()
 * @method TrainingException[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingExceptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingException::class);
    }

    // /**
    //  * @return TrainingException[] Returns an array of TrainingDay objects
    //  */
    public function findAllByTeamCategory(TrainingTeamCategory $teamCategory, int $days=28)
    {
        $today = new \DateTime('today');
        return $this->createQueryBuilder('exception')
            ->leftJoin('exception.teams', 'exception_teams')
            ->leftJoin('exception_teams.category', 'exception_teams_category')
            ->leftJoin('exception.schedule', 'schedule')
            ->leftJoin('schedule.teams', 'schedule_teams')
            ->leftJoin('schedule_teams.category', 'schedule_teams_category')
            ->addSelect('exception')
            ->andWhere('exception.enabled = :enabled')
            ->andWhere('( exception_teams_category.id = :id or schedule_teams_category = :id)')
            ->andWhere('exception.startDate < :start')
            ->andWhere('exception.endDate >= :now')
            ->setParameter('enabled', true)
            ->setParameter('id', $teamCategory->getId())
            ->setParameter('now', $today->format('Y-m-d'))
            ->setParameter('start', $today->modify('+'.$days.' days')->format('Y-m-d'))
            ->orderBy('exception.startDate, exception.endDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }

    public function findAll(int $days=28)
    {
        $today = new \DateTime('today');
        return $this->createQueryBuilder('exception')
            ->leftJoin('exception.teams', 'teams')
            ->leftJoin('exception.schedule', 'schedule')
            ->addSelect('teams')
            ->addSelect('schedule')
            ->andWhere('exception.enabled = :enabled')
            ->andWhere('exception.startDate < :start')
            ->andWhere('exception.endDate >= :now')
            ->setParameter('enabled', true)
            ->setParameter('now', $today->format('Y-m-d'))
            ->setParameter('start', $today->modify('+'.$days.' days')->format('Y-m-d'))
            ->orderBy('exception.startDate, exception.endDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }
}
