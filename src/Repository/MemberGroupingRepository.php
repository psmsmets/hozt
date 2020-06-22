<?php

namespace App\Repository;

use App\Entity\MemberGrouping;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MemberGrouping|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberGrouping|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberGrouping[]    findAll()
 * @method MemberGrouping[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberGroupingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberGrouping::class);
    }

    // /**
    //  * @return MemberGrouping[] Returns an array of MemberGrouping objects
    //  */
    public function getGroupingById(int $id): ?MemberGrouping
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function flush()
    {
        $this->_em->flush();
    }

}
