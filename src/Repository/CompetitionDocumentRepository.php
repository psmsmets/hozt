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
        return $this->createQueryBuilder('d')
            ->innerJoin('d.category','c')
            ->innerJoin('d.competition','o')
            ->innerJoin('o.calendar','e')
            ->addSelect('d')
            ->addSelect('c')
            ->addSelect('o')
            ->addSelect('e')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('e.archived = :archived')
            ->andWhere('c.slug = :slug')
            ->setParameter('enabled', true)
            ->setParameter('archived', false)
            ->setParameter('slug', $slug)
            ->orderBy('e.startTime', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUpcomingCompetitionDocuments(string $slug, int $limit = 5)
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.category','c')
            ->innerJoin('d.competition','o')
            ->innerJoin('o.calendar','e')
            ->addSelect('d')
            ->addSelect('c')
            ->addSelect('o')
            ->addSelect('e')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('e.archived = :archived')
            ->andWhere('( e.endTime >= :today_start or (e.startTime >= :today_end and e.endTime is null) )')
            ->andWhere('c.slug = :slug')
            ->setParameter('enabled', true)
            ->setParameter('archived', false)
            ->setParameter('today_start', date("Y-m-d").' 00:00')
            ->setParameter('today_end', date("Y-m-d").' 23:59')
            ->setParameter('slug', $slug)
            ->orderBy('e.startTime', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
}
