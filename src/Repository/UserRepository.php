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
    
    public function findOneByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.enabled = :enabled')
            ->andWhere('user.email = :email')
            ->setParameter('enabled', true)
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByToken(string $token, string $type): ?User
    {
        $now = new \DateTime('now');
        return $this->createQueryBuilder('user')
            ->andWhere('user.enabled = :enabled')
            ->andWhere('user.secret = :secret')
            ->andWhere('user.secretExpiration > :now')
            ->setParameter('enabled', true)
            ->setParameter('secret', "$type=$token" )
            ->setParameter('now', $now->format('Y-m-d H:i:s') )
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function flush()
    {
        $this->_em->flush();
    }
    
}
