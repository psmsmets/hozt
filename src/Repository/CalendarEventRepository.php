<?php

namespace App\Repository;

use App\Entity\CalendarEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CalendarEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalendarEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalendarEvent[]    findAll()
 * @method CalendarEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CalendarEvent::class);
    }

    // /**
    //  * @return CalendarEvent[] Returns an array of CalendarEvent objects
    //  */
    public function findCalendarEvents(string $start_time, string $end_time)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.category','c')
            ->leftJoin('e.competition','n')
            ->leftJoin('n.teams','t')
            ->addSelect('c')
            ->addSelect('t')
            ->addSelect('n')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('e.startTime >= :startTime')
            ->andWhere('(e.endTime < :endTime or (e.endTime is null and e.startTime < :endTime))')
            ->setParameter('enabled', true)
            ->setParameter('startTime', $start_time)
            ->setParameter('endTime', $end_time)
            ->orderBy('e.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingCalendarEvents(int $limit = 10)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.category','c')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('e.archived = :archived')
            ->andWhere('( e.endTime >= :today_start or (e.startTime >= :today_end and e.endTime is null) )')
            ->setParameter('enabled', true)
            ->setParameter('archived', false)
            ->setParameter('today_start', date("Y-m-d").' 00:00')
            ->setParameter('today_end', date("Y-m-d").' 23:59')
            ->orderBy('e.startTime', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCalendarEvent(string $uuid)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.category','c')
            ->leftJoin('e.competition','n')
            ->leftJoin('n.teams','t')
            ->addSelect('e')
            ->addSelect('c')
            ->addSelect('t')
            ->addSelect('n')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('e.uuid = :uuid')
            ->setParameter('enabled', true)
            ->setParameter('uuid', $uuid)
            ->orderBy('e.startTime', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
