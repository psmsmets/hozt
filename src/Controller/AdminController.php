<?php

namespace App\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

use App\Entity\User;
use App\Entity\BlogPost;
use App\Entity\CalendarCategory;
use App\Entity\ContactFaq;
use App\Entity\ContactForm;
use App\Entity\CompetitionPool;
use App\Entity\SponsorCategory;
use App\Entity\TrainingCoach;
use App\Entity\TrainingTeamCategory;

class AdminController extends BaseAdminController
{

    // Customizes the instantiation of specific entities
    public function createNewUserEntity()
    {
        return new User(array('ROLE_USER'));
    }

    public function createNewBlogPostEntity()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $post = new BlogPost();
        return $post->setAuthor($user);
    }

    public function createNewCalendarCategoryEntity()
    {
        $sequence = (int) $this->getDoctrine()
            ->getRepository(CalendarCategory::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult();
        return new CalendarCategory($sequence+1);
    }

    public function createNewContactFaqEntity()
    {
        $sequence = (int) $this->getDoctrine()
            ->getRepository(ContactFaq::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult();
        return new ContactFaq($sequence+1);
    }

    public function createNewCompetitionPoolEntity()
    {
        $sequence = (int) $this->getDoctrine()
            ->getRepository(CompetitionPool::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult();
        return new CompetitionPool($sequence+1);
    }

    public function createNewContactFormEntity()
    {
        $sequence = (int) $this->getDoctrine()
            ->getRepository(ContactForm::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult();
        return new ContactForm($sequence+1);
    }

    public function createNewSponsorCategoryEntity()
    {
        $sequence = (int) $this->getDoctrine()
            ->getRepository(SponsorCategory::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult();
        return new SponsorCategory($sequence+1);
    }

    public function createNewTrainingCoachEntity()
    {
        $sequence = (int) $this->getDoctrine()
            ->getRepository(TrainingCoach::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult();
        return new TrainingCoach($sequence+1);
    }

    public function createNewTrainingTeamCategoryEntity()
    {
        $sequence = (int) $this->getDoctrine()
            ->getRepository(TrainingTeamCategory::class)
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult();
        return new TrainingTeamCategory($sequence+1);
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
