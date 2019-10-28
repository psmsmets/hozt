<?php

namespace App\Repository;

use App\Entity\EnrolmentEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EnrolmentEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnrolmentEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnrolmentEvent[]    findAll()
 * @method EnrolmentEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnrolmentEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnrolmentEvent::class);
    }

    // /**
    //  * @return EnrolmentEvent Returns a EnrolmentEvent object
    //  */
    public function findNextUpcoming(\DateTimeInterface $reftime = null): ?EnrolmentEvent
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');
        return $this->createQueryBuilder('event')
            ->innerJoin('event.calendar','cal')
            ->leftJoin('event.times','times')
            ->leftJoin('event.inputs','inputs')
            ->leftJoin('inputs.category','category')
            ->addSelect('times')
            ->addSelect('inputs')
            ->addSelect('category')
            ->andWhere('event.enabled = :enabled')
            ->andWhere('cal.startTime >= :reftime')
            ->setParameter('enabled', true)
            ->setParameter('reftime', $reftime)
            ->orderBy('cal.startTime', 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return EnrolmentEvent Returns a EnrolmentEvent object
    //  */
    public function findByUuid(string $uuid): ?EnrolmentEvent
    {
        return $this->createQueryBuilder('event')
            ->innerJoin('event.calendar','cal')
            ->leftJoin('event.times','times')
            ->leftJoin('event.inputs','inputs')
            ->leftJoin('inputs.category','category')
            ->addSelect('times')
            ->addSelect('inputs')
            ->addSelect('category')
            ->andWhere('cal.uuid = :uuid')
            ->andWhere('event.enabled = :enabled')
            ->setParameter('uuid', $uuid)
            ->setParameter('enabled', true)
            ->orderBy('times.startTime,cal.startTime,inputs.category,inputs.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return EnrolmentEvent Returns a EnrolmentEvent object
    //  */
    public function findBySlug(string $slug, \DateTimeInterface $reftime = null): ?EnrolmentEvent
    {
        if (is_null($reftime)) $reftime = new \DateTimeImmutable('today midnight');
        return $this->createQueryBuilder('event')
            ->innerJoin('event.calendar','cal')
            ->leftJoin('event.times','times')
            ->leftJoin('event.inputs','inputs')
            ->leftJoin('inputs.category','category')
            ->addSelect('times')
            ->addSelect('inputs')
            ->addSelect('category')
            ->andWhere('event.slug = :slug')
            ->andWhere('event.enabled = :enabled')
            ->andWhere('cal.startTime >= :reftime')
            ->setParameter('slug', $slug)
            ->setParameter('enabled', true)
            ->setParameter('reftime', $reftime)
            ->orderBy('times.startTime,cal.startTime,inputs.category,inputs.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findPeriodEvents(\DateTimeInterface $periodStart, \DateTimeInterface $periodEnd)
    {
        return $this->createQueryBuilder('event')
            ->innerJoin('event.calendar','cal')
            ->leftJoin('event.times','times')
            ->leftJoin('event.inputs','inputs')
            ->leftJoin('inputs.category','category')
            ->addSelect('times')
            ->addSelect('inputs')
            ->addSelect('category')
            ->andWhere('event.enabled = :enabled')
            ->andWhere('( cal.startTime >= :start and cal.startTime < :end and (cal.endTime < :end or cal.endTime is null) )')
            ->setParameter('enabled', true)
            ->setParameter('start', $periodStart)
            ->setParameter('end', $periodEnd)
            ->orderBy('times.startTime,cal.startTime,inputs.category,inputs.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
