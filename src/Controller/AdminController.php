<?php

namespace App\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
//use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

# entities
use App\Entity\StaticPage;
use App\Entity\BlogPost;
use App\Entity\BlogCategory;
use App\Entity\CarouselSlide;
use App\Entity\TrainingCoach;
use App\Entity\TrainingDay;
use App\Entity\TrainingTime;
use App\Entity\TrainingTeam;
use App\Entity\TrainingTeamCategory;
use App\Entity\TrainingSchedule;
use App\Entity\TrainingException;
use App\Entity\ContactFaq;
use App\Entity\ContactForm;
use App\Entity\CalendarCategory;
use App\Entity\CalendarEvent;
use App\Entity\Competition;
use App\Entity\CompetitionState;
use App\Entity\Sponsor;
use App\Entity\SponsorCategory;
use App\Entity\Clubfeest;
use App\Entity\TryoutEnrolment;
use App\Entity\Tryout;

# repositories
use App\Repository\TryoutEnrolmentRepository;
use App\Repository\TryoutRepository;

class AdminController extends EasyAdminController
{

    // Customizes the instantiation of specific entities
    public function createNewUserEntity()
    {
        return new User(array('ROLE_USER'));
    }

    public function createNewBlogPostEntity()
    {
        $post = new BlogPost();
        $post->setCategory(
            $this->getDoctrine()
                ->getRepository(BlogCategory::class)
                ->findOneBy(
                  ['enabled'=>true,'id'=>$this->getParameter('app.defaults.blogCategory.id')]
                )
            );
        $post->setAuthor( $this->container->get('security.token_storage')->getToken()->getUser() );
        return $post;
    }

    public function createNewCalendarCategoryEntity()
    {
        $seq = (int) $this->getDoctrine()
            ->getRepository(CalendarCategory::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult()
            ;
        $cat = new CalendarCategory();
        return $cat->setSequence($seq+1);
    }

    public function createNewCalendarEventEntity()
    {
        $cat = $this->getDoctrine()
            ->getRepository(CalendarCategory::class)
            ->findOneBy(
              ['enabled'=>true,'id'=>$this->getParameter('app.defaults.calendarCategory.id')]
            );
        $new = new CalendarEvent();
        return $new->setCategory($cat);
    }

    public function createNewCompetitionEntity()
    {
        $pool = $this->getDoctrine()
            ->getRepository(CompetitionPool::class)
            ->findOneBy(
              ['enabled'=>true,'id'=>$this->getParameter('app.defaults.competitionPool.id')]
            );
        $new = new Competition();
        return $new->setPool($pool);
    }

    public function createNewCompetitionDocumentCategoryEntity()
    {
        $seq = (int) $this->getDoctrine()
            ->getRepository(CompetitionDocumentCategory::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult()
            ;
        $cat = new CompetitionDocumentCategory();
        return $cat->setSequence($seq+1);
    }

    public function createNewContactFaqEntity()
    {
        $seq = (int) $this->getDoctrine()
            ->getRepository(ContactFaq::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult()
            ;
        $new = new ContactFaq();
        return $new->setSequence($seq+1);
    }

    public function createNewContactFormEntity()
    {
        $seq = (int) $this->getDoctrine()
            ->getRepository(ContactForm::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult()
            ;
        $new = new ContactForm();
        return $new->setSequence($seq+1);
    }

    public function createNewSponsorCategoryEntity()
    {
        $seq = (int) $this->getDoctrine()
            ->getRepository(SponsorCategory::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult()
            ;
        $new = new SponsorCategory();
        return $new->setSequence($seq+1);
    }

    public function createNewTrainingExceptionEntity()
    {
        $teams = $this->getDoctrine()
            ->getRepository(TrainingTeam::class)
            ->getEnabled()
            ;
        $new = new TrainingException();
        foreach( $teams as $team ){
            $new->addTeam($team);
        }
        return $new;
    }

    public function createNewTrainingTeamCategoryEntity()
    {
        $seq = (int) $this->getDoctrine()
            ->getRepository(TrainingTeamCategory::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult()
            ;
        $new = new TrainingTeamCategory();
        return $new->setSequence($seq+1);
    }

    // special persist
    public function persistBlogPostEntity($entity)
    {
        $entity->setUpdatedAt();
        if ($entity->getPinned()) {
            $this->unpinBlogPosts();
        }
        parent::persistEntity($entity);
    }

    public function persistCalendarEventEntity($entity)
    {
        $entity->setUpdatedAt();
        $entity->setStartTime($entity->trueStartTime());
        if (!is_null($entity->getEndTime())) {
            $entity->setEndTime($entity->trueEndTime());
        }
        parent::persistEntity($entity);
    }

    public function persistTrainingScheduleEntity($entity)
    {
        $this->checkTrainingScheduleEntity($entity);
    }

    public function persistTrainingExceptionEntity($entity)
    {
        $this->checkTrainingExceptionEntity($entity);
    }

    public function persistCompetitionDocumentEntity($entity)
    {
        $comp = $entity->getCompetition();
        $comp->setUpdatedAt();

        $event = $comp->getCalendar();
        $event->setUpdatedAt();
        $this->em->flush();

        parent::persistEntity($entity);
    }

    // special update
    private function unpinBlogPosts(int $current=null)
    {
        $posts = $this->getDoctrine()->getRepository(BlogPost::class)->findPinnedBlogPosts($current);
        if (empty($posts)) {
            return;
        }
        foreach ($posts as $post) {
            $post->setPinned(false);
        }
        $this->em->flush();
    }

    public function updateBlogPostEntity($entity)
    {
        $entity->setUpdatedAt();
        if ($entity->getPinned()) {
            $this->unpinBlogPosts($entity->getId());
        }
        parent::persistEntity($entity);
    }

    public function updateBlogCategoryEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getPosts())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Blog categorie heeft gerelateerde posts. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateCalendarEventEntity($entity)
    {
        $entity->setUpdatedAt();
        $entity->setStartTime($entity->trueStartTime());
        if (!is_null($entity->getEndTime())) {
            $entity->setEndTime($entity->trueEndTime());
        }
        if (!$entity->getEnabled()) {
            if (count($entity->getPosts())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Kalender event heeft gerelateerde posts. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateCalendarCategoryEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getEvents())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Kalender categorie heeft gerelateerde events. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateCompetitionEntity($entity)
    {
        $event = $entity->getCalendar();
        $event->setUpdatedAt();
        $this->em->flush();

        $entity->setUpdatedAt();
        parent::persistEntity($entity);
    }

    public function updateCompetitionPoolEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getCompetitions())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Zwembad type heeft gerelateerde wedstrijden. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateCompetitionDocumentEntity($entity)
    {
        $comp = $entity->getCompetition();
        $comp->setUpdatedAt();
        $event = $comp->getCalendar();
        $event->setUpdatedAt();
        $this->em->flush();

        $entity->setUpdatedAt();
        parent::persistEntity($entity);
    }

    public function updateCompetitionDocumentCategoryEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getDocuments())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: wedstrijd bijlage categorie type heeft gerelateerde documenten. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateTrainingCoachEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getTeams())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Training coach heeft gerelateerde data. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateTrainingScheduleEntity($entity)
    {
        $this->checkTrainingScheduleEntity($entity);
    }

    public function checkTrainingScheduleEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getTeams())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Training schedule heeft gerelateerde groepen. Deactiveren niet toegestaan.');
            }
        }
        if ($entity->getPersistent() and is_null($entity->getEndDate())) {
            $entity->setPersistent(false);
            $this->addFlash('danger', 'Fout: Uitzondering enkel toegestaan met einddatum.');
        }
        if (!is_null($entity->getEndDate()) and $entity->getEndDate() < $entity->getStartDate()) {
            $this->addFlash('danger', 'Fout: einddatum moet groter of gelijk zijn aan de startdatum.');
        }
        parent::persistEntity($entity);
    }

    public function updateTrainingExceptionEntity($entity)
    {
        $this->checkTrainingExceptionEntity($entity);
    }

    public function checkTrainingExceptionEntity($entity)
    {
        if ($entity->getStartDate() > $entity->getEndDate()) {
            $this->addFlash('danger', 'Fout: startdatum > einddatum.');
            return;
        }

        $start = $entity->getStartDate();
        $end = $entity->calcEndDate();
        $period = $entity->getPeriod();
        $days = $entity->getDays();

        /* teams and schedule */
        if ( count($entity->getSchedule())>0 and count($entity->getTeams())>0 ) {

            $teams = $entity->getTeams();

            /* check if schedule is valid in period and for the given team */
            foreach ($entity->getSchedule() as $schedule) {
                $scheduleTeams = $schedule->getTeams();
                $check = 0;
                foreach ($teams as $team) {
                    if ($scheduleTeams->contains($team)) $check++;
                }
                if ( ! $schedule->isActive($start,$end,$days) or $check == 0 ) {
                    $this->addFlash('warning', "Uurrooster \"$schedule\" valt niet in de periode voor de opgegeven groepen!");
                    $entity->removeSchedule($schedule);
                }
            }

        } else {

            /* check if schedule is valid in period */
            foreach ($entity->getSchedule() as $schedule) {
                if ( ! $schedule->isActive($start,$end,$days) ) {
                    $this->addFlash('warning', "Uurrooster \"$schedule\" valt niet in de periode!");
                    $entity->removeSchedule($schedule);
                }
            }

            /* check if team is valid in period */
            foreach ($entity->getTeams() as $team) {
                $check = 0;
                foreach ($team->getSchedule() as $schedule) {
                    if ($schedule->isActive($start,$end,$days)) $check++;
                }
                if ( $check == 0 ) {
                    $this->addFlash('warning', "Groep \"$team\" zwemt niet in de periode!");
                    $entity->removeTeam($team);
                }
            }
        }
        if (count($entity->getTeams()) == 0 and count($entity->getSchedule()) == 0) {
            $this->addFlash('danger', "Fout: geen groepen en/of uurroosters gegeven!");
            return;
        }
        parent::persistEntity($entity);
    }

    public function updateTrainingTeamEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getSchedule())>0 or count($entity->getCoaches())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Training groep heeft gerelateerde data. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateTrainingTeamCategoryEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getTeams())>0 or count($entity->getCompetitions())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Training categorie heeft gerelateerde data. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateTrainingTimeEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getSchedule())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Training tijdstip heeft gerelateerde data. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateTryoutEntity($entity)
    {
    // todo: get tryout from database and check that date. Inject repository!!
    //       same trick can be user to check enabled status elsewhere.
        $now = new \DateTime("now");
        $entity->setUpdatedAt();
        if ($now > $entity->getEnrolFrom()) {
            $this->addFlash('danger', 'Fout: Inschrijvingen zijn bezig. Wijzigingen zijn niet meer toegestaan.');
            return;
        }
        parent::persistEntity($entity);
    }

    public function persistTryoutEnrolmentEntity($entity )
    {
        $tryout = $entity->getTryout();
        if (!$entity->getWithdrawn()) $tryout->nofEnrolmentsSubtractOne();
        $this->em->flush();

        parent::persistEntity($entity);
    }

    public function updateSponsorCategoryEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getSponsors())>0) {
                $entity->setEnabled(true);
                $this->addFlash('danger', 'Fout: Sponsor categorie heeft gerelateerde data. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    // General update
    public function updateEntity($entity)
    {
        if (method_exists($entity, 'setUpdatedAt')) {
            $entity->setUpdatedAt();
        }
        parent::persistEntity($entity);
    }

    // Remove
    public function removeTrainingScheduleEntity($entity)
    {
        $now = new \DateTime("today midnight");
        if (is_null($entity->getEndDate())) {
            $this->addFlash('danger', 'Fout: Verwijderen enkel toegestaan na einddatum!');
            return;
        }
        elseif ($entity->getEndDate() >= $now or $entity->getStartDate() >= $now ) {
            $this->addFlash('danger', 'Fout: Verwijderen enkel toegestaan voor verlopen trainingsuren (start en einddatum in het verleden)! Bevestig eerst de einddatum alvorens te verwijderen.');
            return;
        }
        parent::removeEntity($entity);
    }

    public function removeTrainingExceptionEntity($entity)
    {
        $now = new \DateTime("today midnight");
        if ($entity->getEndDate() >= $now or $entity->getStartDate() >= $now ) {
            $this->addFlash('danger', 'Fout: Verwijderen enkel toegestaan voor verlopen uitzondering (start en einddatum in het verleden)! Bevestig eerst de einddatum alvorens te verwijderen.');
            return;
        }
        parent::removeEntity($entity);
    }

    public function removeTryoutEntity($entity)
    {
        $now = new \DateTime("today midnight");
        if ( $entity->getEndTime() >= $now  or sizeof($entity->getEnrolments())>0 ) {
            $this->addFlash('danger', 'Fout: Verwijderen enkel toegestaan na afloop zonder inschrijvingen.');
            return;
        }
        parent::removeEntity($entity);
    }


/*
    public function createTrainingCoachEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        //$user = $this->get('security.token_storage')->getToken()->getUser();

        $formBuilder->add('teams', EntityType::class, [
            'class' => 'App\Entity\TrainingTeam',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->where('t.enabled = :enabled')
                    ->setParameter('enabled', true);
                    //->setParameter('user', $user);
            },
        ]);

        return $formBuilder;
    }
*/

}
