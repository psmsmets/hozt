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
        $reftime = new \DateTime("today midnight -35 days");
        return $er->createQueryBuilder('c')
            ->andwhere('c.archived = :archived')
            ->andwhere('c.startTime >= :startTime')
            ->setParameter('archived', false)
            ->setParameter('startTime', $reftime)
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
    public static function getUnlockedEnrolmentInputCategories(EntityRepository $er) {
        return $er->createQueryBuilder('inputCat')
            ->leftJoin('inputCat.elements', 'elements')
            ->leftJoin('elements.event', 'event')
            ->andwhere('(event.enabled = :enabled or event is null)')
            ->setParameter('enabled', false)
        ;
    }
    public static function getInactiveEnrolmentEvents(EntityRepository $er) {
        return $er->createQueryBuilder('event')
            ->andwhere('event.enabled = :enabled')
            ->setParameter('enabled', false)
        ;
    }
    public static function getPotentialEnrolmentEvents(EntityRepository $er) {
        $reftime = new \DateTime("today midnight +14 days");
        return $er->createQueryBuilder('event')
            ->leftJoin('event.enrolmentEvent', 'enrol')
            ->leftJoin('event.competition', 'comp')
            ->andwhere('enrol.id is null')
            ->andwhere('comp.id is null')
            ->andwhere('event.startTime >= :startTime')
            ->andwhere('event.archived = :archived')
            ->setParameter('archived', false)
            ->setParameter('startTime', $reftime)
        ;
    }
    public static function getTrainingTime(EntityRepository $er) {
        return $er->createQueryBuilder('time')
            ->orderBy('time.startTime', 'ASC')
        ;
    }
    public static function getTrainingSchedule(EntityRepository $er) {
        return $er->createQueryBuilder('c')
            ->innerJoin('c.time','t')
            ->andwhere('c.persistent = :persistent')
            ->setParameter('persistent', false)
            ->orderBy('c.dayNumber, t.startTime', 'ASC')
        ;
    }
    public static function getAdminUsers(EntityRepository $er) {
        return $er->createQueryBuilder('u')
            ->andWhere('u.enabled = true')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%ADMIN%')
        ;
    }
}
