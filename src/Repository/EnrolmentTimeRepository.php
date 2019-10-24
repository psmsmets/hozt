<?php

namespace App\Repository;

use App\Entity\EnrolmentTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EnrolmentTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnrolmentTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnrolmentTime[]    findAll()
 * @method EnrolmentTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnrolmentTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnrolmentTime::class);
    }

}
