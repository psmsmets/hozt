<?php

namespace App\Repository;

//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;

//use App\Entity\User;
//use App\Entity\TrainingTeam;

class EasyAdminRepository
{
    public function getEnabled(EntityRepository $er) {
        return $er->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->setParameter('enabled', true)
        ;
    }
    public function getFilteredCalendarEvents(EntityRepository $er) {
        $today = new \DateTime("today midnight");
        return $er->createQueryBuilder('c')
            ->andwhere('c.enabled = :enabled')
            ->andwhere('c.archived = :archived')
            ->andwhere('c.startTime >= :startTime')
            ->setParameter('enabled', true)
            ->setParameter('archived', false)
            ->setParameter('startTime', $today->modify('-35 days')->format('Y-m-d'))
            ->orderBy('c.startTime', 'ASC')
        ;
    }
    public function getUnassociatedCalendarEvents(EntityRepository $er) {
        return $er->createQueryBuilder('e')
            ->leftJoin('e.competition', 'c')
            ->andwhere('e.enabled = :enabled')
            ->andwhere('e.isCompetition = :enabled')
            ->andwhere('c.id is null')
            ->setParameter('enabled', true)
        ;
    }
}
