<?php

namespace App\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
//use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

use App\Entity\User;
use App\Entity\BlogPost;
use App\Entity\BlogCategory;
use App\Entity\CalendarEvent;
use App\Entity\CalendarCategory;
use App\Entity\Competition;
use App\Entity\CompetitionPool;
use App\Entity\ContactFaq;
use App\Entity\ContactForm;
use App\Entity\SponsorCategory;
use App\Entity\TrainingCoach;
use App\Entity\TrainingTeamCategory;

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

    public function createNewTrainingCoachEntity()
    {
        $seq = (int) $this->getDoctrine()
            ->getRepository(TrainingCoach::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult()
            ;
        $new = new TrainingCoach();
        return $new->setSequence($seq+1);
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
            if (!$entity->getSpecial()) {
                $entity->setPinned(false);
            } else {
                $this->unpinBlogPosts();
            }
        }
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
            if (!$entity->getSpecial()) {
                $entity->setPinned(false);
                $this->addFlash('error', 'Fout: Pinnend blog post moet op voorpagina staan.');
            } else {
                $this->unpinBlogPosts($entity->getId());
            }
        }
        parent::persistEntity($entity);
    }

    public function updateBlogCategoryEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getPosts())>0) {
                $entity->setEnabled(true);
                $this->addFlash('error', 'Fout: Blog categorie heeft gerelateerde posts. Deactiveren niet toegestaan.');
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
                $this->addFlash('error', 'Fout: Kalender categorie heeft gerelateerde events. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateCompetitionPoolEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getCompetitions())>0) {
                $entity->setEnabled(true);
                $this->addFlash('error', 'Fout: Zwembad type heeft gerelateerde wedstrijden. Deactiveren niet toegestaan.');
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
                $this->addFlash('error', 'Fout: Training coach heeft gerelateerde data. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateTrainingScheduleEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getTeams())>0) {
                $entity->setEnabled(true);
                $this->addFlash('error', 'Fout: Training schedule heeft gerelateerde groepen. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateTrainingTeamEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getSchedule())>0 or count($entity->getCoaches())>0) {
                $entity->setEnabled(true);
                $this->addFlash('error', 'Fout: Training group heeft gerelateerde data. Deactiveren niet toegestaan.');
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
                $this->addFlash('error', 'Fout: Training categorie heeft gerelateerde data. Deactiveren niet toegestaan.');
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
                $this->addFlash('error', 'Fout: Training tijdstip heeft gerelateerde data. Deactiveren niet toegestaan.');
            }
        }
        parent::persistEntity($entity);
    }

    public function updateSponsorCategoryEntity($entity)
    {
        $entity->setUpdatedAt();
        if (!$entity->getEnabled()) {
            if (count($entity->getSponsors())>0) {
                $entity->setEnabled(true);
                $this->addFlash('error', 'Fout: Sponsor categorie heeft gerelateerde data. Deactiveren niet toegestaan.');
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
