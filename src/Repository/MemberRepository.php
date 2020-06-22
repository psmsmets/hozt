<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    // /**
    //  * @return Member[] Returns an array of Member objects
    //  */
    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.user = :user')
            ->setParameter('user', $user)
            ->orderBy('m.firstname', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByMemberId(int $memberId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.memberId = :memberId')
            ->setParameter('memberId', $memberId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getLastMemberId(): ?int
    {
        return $this->createQueryBuilder('m')
            ->select('MAX(m.memberId) as memberId')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function flush()
    {
        $this->_em->flush();
    }
}
