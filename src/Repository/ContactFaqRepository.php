<?php

namespace App\Repository;

use App\Entity\ContactFaq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContactFaq|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactFaq|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactFaq[]    findAll()
 * @method ContactFaq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactFaqRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactFaq::class);
    }

    // /**
    //  * @return ContactFaq[] Returns an array of ContactFaq objects
    //  */
    public function findAllEnabled()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.sequence', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getLastSequence(): ?int
    {
        return $this->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult();
    }

}
