<?php

namespace App\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

use App\Entity\User;
use App\Entity\BlogPost;
use App\Entity\TrainingTeam;

class AdminController extends BaseAdminController
{

    private $slugger;

    public function __construct(\Cocur\Slugify\SlugifyInterface $slugify)
    {
        $this->slugger = $slugify;
    }

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

    // General create 
    public function persistEntity($entity)
    {
        $this->updateSlug($entity);
        parent::persistEntity($entity);
    }

    // General update
    public function updateEntity($entity)
    {
        if (method_exists($entity, 'setUpdatedAt')) {
            $entity->setUpdatedAt();
        }
        if (method_exists($entity, 'setSpecial')) {
            $this->updateSlug($entity,true);
        } else {
            $this->checkSlug($entity,true);
        }
        parent::persistEntity($entity);
    }

    private function checkSlug($entity)
    {
        if (method_exists($entity, 'setSlug') ) {
            $entity->setSlug($this->slugger->slugify($entity->getSlug()));
        }
    }

    private function updateSlug($entity, bool $force = false)
    {
        if (method_exists($entity, 'setSlug') and method_exists($entity, 'getTitle')) {
            if (is_null($entity->getSlug()) or $force) {
                $entity->setSlug($this->slugger->slugify($entity->getTitle()));
            }
        }
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
