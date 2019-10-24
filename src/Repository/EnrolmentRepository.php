<?php

namespace App\Repository;

use App\Entity\Enrolment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Enrolment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enrolment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enrolment[]    findAll()
 * @method Enrolment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnrolmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enrolment::class);
    }

    // /**
    //  * @return Enrolment[] Returns an array of Enrolment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findByUuid(string $uuid): ?Enrolment
    {
        return $this->createQueryBuilder('enrolment')
            ->innerJoin('enrolment.event','event')
            ->innerJoin('enrolment.time','time')
            ->innerJoin('event.inputs','inputs')
            ->innerJoin('inputs.category','category')
            ->addSelect('event')
            ->addSelect('time')
            ->addSelect('inputs')
            ->addSelect('category')
            ->andWhere('enrolment.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
