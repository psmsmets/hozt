<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\MemberAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MemberAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberAddress[]    findAll()
 * @method MemberAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberAddress::class);
    }

    public function findOneById(int $id, User $user): ?MemberAddress
    {
        return $this->createQueryBuilder('a')
            ->andWhere('ma.id = :id')
            ->andWhere('ma.user = :user')
            ->setParameter('id', $id)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function flush()
    {
        $this->_em->flush();
    }
}
