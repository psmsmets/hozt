<?php

namespace App\Repository;

use App\Entity\SponsorCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SponsorCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SponsorCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SponsorCategory[]    findAll()
 * @method SponsorCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SponsorCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SponsorCategory::class);
    }

    // /**
    //  * @return SponsorCategory[] Returns an array of SponsorCategory objects
    //  */
    public function findAllActiveSponsors()
    {
        $reftime = new \DateTime('today');

        return $this->createQueryBuilder('c')
            ->innerJoin('c.sponsors','s')
            ->addSelect('c')
            ->addSelect('s')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('s.enabled = :enabled')
            ->andWhere('( s.publishAt <= :reftime and (s.publishUntil >= :reftime or s.publishUntil is null) )')
            ->setParameter('enabled', true)
            ->setParameter('reftime', $reftime)
            ->orderBy('c.sequence, s.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
