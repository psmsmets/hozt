<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class EasyAdminRepository
{
    public static function getEnabled(EntityRepository $er) {
        return $er->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->setParameter('enabled', true)
        ;
    }
    public static function getEnabledOrderBySequence(EntityRepository $er) {
        return $er->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.sequence', 'ASC')
        ;
    }
    public static function getFilteredCalendarEvents(EntityRepository $er) {
        $today = new \DateTime("today midnight");
        return $er->createQueryBuilder('c')
            ->andwhere('c.archived = :archived')
            ->andwhere('c.startTime >= :startTime')
            ->setParameter('archived', false)
            ->setParameter('startTime', $today->modify('-35 days')->format('Y-m-d'))
            ->orderBy('c.startTime', 'ASC')
        ;
    }
    public static function getUnarchivedCompetitionEvents(EntityRepository $er) {
        return $er->createQueryBuilder('c')
            ->innerJoin('c.calendar','e')
            ->andwhere('e.archived = :archived')
            ->setParameter('archived', false)
            ->orderBy('e.startTime', 'ASC')
        ;
    }
    public static function getUnassociatedCalendarEvents(EntityRepository $er) {
        return $er->createQueryBuilder('e')
            ->leftJoin('e.competition', 'c')
            ->andwhere('e.enabled = :enabled')
            ->andwhere('e.isCompetition = :enabled')
            ->andwhere('c.id is null')
            ->setParameter('enabled', true)
        ;
    }
    public static function getTrainingTime(EntityRepository $er) {
        return $er->createQueryBuilder('time')
            ->orderBy('time.startTime', 'ASC')
        ;
    }
    public static function getTrainingSchedule(EntityRepository $er) {
        return $er->createQueryBuilder('c')
            ->andwhere('c.persistent = :persistent')
            ->setParameter('persistent', false)
            ->orderBy('c.startTime', 'ASC')
        ;
    }
    public static function getMemberGrouping(EntityRepository $er) {
        return $er->createQueryBuilder('g')
            ->where('g.parent is not null')
            ->orderBy('g.fullname', 'ASC')
        ;
    }
}
