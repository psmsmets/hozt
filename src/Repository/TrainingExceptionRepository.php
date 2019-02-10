<?php

namespace App\Repository;

use App\Entity\TrainingException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrainingException|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingException|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingException[]    findAll()
 * @method TrainingException[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingExceptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingException::class);
    }

    // /**
    //  * @return TrainingException[] Returns an array of TrainingDay objects
    //  */
    public function findAllByTeamCategory(int $id, int $days=28)
    {
        $today = new \DateTime('today');
        return $this->createQueryBuilder('e')
            ->innerJoin('e.teams', 't')
            ->innerJoin('t.category', 'c')
            ->addSelect('e')
            ->andWhere('e.enabled = :enabled')
            ->andWhere('t.enabled = :enabled')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('c.id = :id')
            ->andWhere('e.startDate < :start')
            ->andWhere('e.endDate >= :now')
            ->setParameter('enabled', true)
            ->setParameter('id', $id)
            ->setParameter('now', $today->format('Y-m-d'))
            ->setParameter('start', $today->modify('+'.$days.' days')->format('Y-m-d'))
            ->orderBy('e.startDate, e.endDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;     
    }
}
