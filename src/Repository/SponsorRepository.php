<?php

namespace App\Repository;

use App\Entity\Sponsor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Sponsor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sponsor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sponsor[]    findAll()
 * @method Sponsor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SponsorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Sponsor::class);
    }

    // /**
    //  * @return Sponsor[] Returns an array of Sponsor objects
    //  */
    public function findAllActiveCoreSponsors()
    {
        $reftime = new \DateTime('today');

        return $this->createQueryBuilder('s')
            ->innerJoin('s.category','c')
            ->addSelect('s')
            ->addSelect('c')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('c.core = :enabled')
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
