<?php

namespace App\Repository;

use App\Entity\Tryout;
use App\Entity\TryoutEnrolment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TryoutEnrolment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TryoutEnrolment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TryoutEnrolment[]    findAll()
 * @method TryoutEnrolment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TryoutEnrolmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TryoutEnrolment::class);
    }

    public function findEnrolment(string $uuid = null)
    {
        if (is_null($uuid)) return null;
        return $this->createQueryBuilder('enrol')
            ->leftJoin('enrol.tryout','tryout')
            ->leftJoin('enrol.category','category')
            ->addSelect('tryout')
            ->addSelect('category')
            ->andWhere('enrol.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findEnrolments(string $uuid = null)
    {
        if (is_null($uuid)) return null;
        return $this->createQueryBuilder('enrol')
            ->leftJoin('enrol.tryout','tryout')
            ->leftJoin('enrol.category','category')
            ->addSelect('tryout')
            ->addSelect('category')
            ->andWhere('tryout.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getResult()
        ;
    }

    public function countEnrolments(Tryout $tryout)
    {
        return $this->createQueryBuilder('enrol')
            ->leftJoin('enrol.tryout','tryout')
            ->select('count(enrol.id)')
            ->where('tryout.id = :id')
            ->andwhere('enrol.withdrawn = :wd')
            ->setParameter('id', $tryout->getId())
            ->setParameter('wd', false)
            ->getQuery()
            ->getSingleScalarResult()
        ;    
    }

    public function flush()
    {
        $this->_em->flush();
    }
}
