<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    public function findOneByEmail(string $email, ?bool $enabled = true ): ?User
    {
        $qb = $this->createQueryBuilder('user');
        $qb->andWhere('user.email = :email')->setParameter('email', $email);
        if ( !is_null($enabled) ) 
        {
            $qb->andWhere('user.enabled = :enabled')->setParameter('enabled', $enabled);
        }
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findOneByMobilePhone(string $mobile, ?bool $enabled = true ): ?User
    {
        $qb = $this->createQueryBuilder('user');
        $qb->andWhere('user.mobilePhone = :mobile')->setParameter('mobile', $mobile);
        if ( !is_null($enabled) ) 
        {
            $qb->andWhere('user.enabled = :enabled')->setParameter('enabled', $enabled);
        }
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findOneByToken(string $token, string $type): ?User
    {
        $reftime = new \DateTime('now');

        return $this->createQueryBuilder('user')
            ->andWhere('user.enabled = :enabled')
            ->andWhere('user.secret = :secret')
            ->andWhere('user.secretExpiration > :now')
            ->setParameter('enabled', true)
            ->setParameter('secret', "$type=$token" )
            ->setParameter('now', $reftime )
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function flush()
    {
        $this->_em->flush();
    }
    
}
