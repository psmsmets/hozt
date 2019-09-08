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
    public function findCalendarEvents(\DateTimeInterface $periodStart, \DateTimeInterface $periodEnd)
    {
        return $this->createQueryBuilder('event')
            ->innerJoin('event.category','cat')
            ->leftJoin('event.competition','competition')
            ->leftJoin('competition.documents','docs')
            ->leftJoin('docs.category','docsCat')
            ->leftJoin('competition.teams','teams')
            ->addSelect('event')
            ->addSelect('cat')
            ->addSelect('competition')
            ->addSelect('docs')
            ->addSelect('docsCat')
            ->addSelect('teams')
            ->andWhere('event.enabled = :enabled')
            ->andWhere('event.startTime >= :startTime')
            ->andWhere('(event.endTime < :endTime or (event.endTime is null and event.startTime < :endTime))')
            ->setParameter('enabled', true)
            ->setParameter('startTime', $periodStart->format('Y-m-d'))
            ->setParameter('endTime', $periodEnd->format('Y-m-d'))
            ->orderBy('event.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingCalendarEvents(int $limit = 10)
    {
        return $this->createQueryBuilder('event')
            ->innerJoin('event.category','cat')
            ->andWhere('cat.enabled = :enabled')
            ->andWhere('event.enabled = :enabled')
            ->andWhere('event.cancelled = :cancelled')
            ->andWhere('( event.endTime >= :today_start or (event.startTime >= :today_start and event.endTime is null) )')
            ->setParameter('enabled', true)
            ->setParameter('cancelled', false)
            ->setParameter('today_start', date("Y-m-d").' 00:00')
            //->setParameter('today_end', date("Y-m-d").' 23:59')
            ->orderBy('event.startTime', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCalendarEvent(string $uuid)
    {
        return $this->createQueryBuilder('event')
            ->innerJoin('event.category','cat')
            ->leftJoin('event.competition','competition')
            ->leftJoin('competition.teams','teams')
            ->leftJoin('competition.documents','docs')
            ->leftJoin('event.posts','posts')
            ->addSelect('event')
            ->addSelect('cat')
            ->addSelect('competition')
            ->addSelect('teams')
            ->addSelect('docs')
            ->addSelect('posts')
            ->andWhere('event.enabled = :enabled')
            ->andWhere('event.uuid = :uuid')
            ->setParameter('enabled', true)
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findCalendarEventByByLatestCompetitionDocuments(string $slug, int $limit = 5)
    {
        return $this->createQueryBuilder('event')
            ->select('distinct(event)')
            ->innerJoin('event.competition','comp')
            ->innerJoin('comp.documents','doc')
            ->innerJoin('doc.category','dcat')
            ->andWhere('event.enabled = :enabled')
            ->andWhere('dcat.slug = :slug')
            ->addSelect('event')
            ->setParameter('enabled', true)
            ->setParameter('slug', $slug)
            //->orderBy('event.startTime', 'DESC')
            ->orderBy('doc.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPastCalendarEvents(int $days = 21, \DateTime $reftime = null)
    {
        $reftime = new \DateTime("today midnight - $days days");
        return $this->createQueryBuilder('event')
            ->andWhere('event.archived = :archived')
            ->andWhere('( event.endTime < :reftime or (event.startTime < :reftime and event.endTime is null) )')
            ->setParameter('archived', false)
            ->setParameter('reftime', $reftime->format("Y-m-d"))
            ->getQuery()
            ->getResult()
        ;
    }

    public function flush()
    {
        $this->_em->flush();
    }

}
