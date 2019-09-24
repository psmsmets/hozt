<?php

namespace App\Repository;

use App\Entity\CompetitionDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetitionDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionDocument[]    findAll()
 * @method CompetitionDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionDocumentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetitionDocument::class);
    }

    public function findLatestCompetitionDocuments(string $slug, int $limit = 5)
    {
        return $this->createQueryBuilder('doc')
            ->innerJoin('doc.category','cat')
            ->innerJoin('doc.competition','comp')
            ->innerJoin('comp.calendar','event')
            ->addSelect('cat')
            ->addSelect('comp')
            ->addSelect('event')
            ->andWhere('COALESCE(doc.document, doc.url) is not null')
            ->andWhere('event.cancelled = :cancelled')
            ->andWhere('cat.slug = :slug')
            ->setParameter('cancelled', false)
            ->setParameter('slug', $slug)
            ->orderBy('event.startTime', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingCompetitionDocuments(string $slug, int $limit = 5)
    {
        $reftime = new \DateTime('today midnight');

        return $this->createQueryBuilder('doc')
            ->innerJoin('doc.category','cat')
            ->innerJoin('doc.competition','comp')
            ->innerJoin('comp.calendar','event')
            ->addSelect('cat')
            ->addSelect('comp')
            ->addSelect('event')
            ->andWhere('event.cancelled = :cancelled')
            ->andWhere('( event.endTime >= :today_start or (event.startTime >= :today_start and event.endTime is null) )')
            ->andWhere('cat.slug = :slug')
            ->andWhere('COALESCE(doc.document, doc.url) is not null')
            ->setParameter('cancelled', false)
            ->setParameter('today_start', $reftime)
            ->setParameter('slug', $slug)
            ->orderBy('event.startTime', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPastCompetitionDocuments()
    {
        $reftime = new \DateTime('today midnight');

        return $this->createQueryBuilder('doc')
            ->innerJoin('doc.category','cat')
            ->innerJoin('doc.competition','comp')
            ->innerJoin('comp.calendar','event')
            ->addSelect('cat')
            ->addSelect('comp')
            ->addSelect('event')
            ->andWhere('cat.autoCleanup = :autoCleanup')
            ->andWhere('( event.endTime < :reftime or (event.startTime < :reftime and event.endTime is null) )')
            ->setParameter('autoCleanup', true)
            ->setParameter('reftime', $reftime)
            ->getQuery()
            ->getResult()
        ;
    }

    public function flush()
    {
        $this->_em->flush();
    }
}
