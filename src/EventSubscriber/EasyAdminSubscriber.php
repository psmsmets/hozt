<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\EntityRepository;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\BlogPost;
use App\Entity\BlogCategory;
use App\Entity\Tryout;
use App\Entity\TryoutEnrolment;

# repositories
use App\Repository\TryoutRepository;
use App\Repository\TryoutEnrolmentRepository;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $em;

    public function __construct(\Cocur\Slugify\SlugifyInterface $slugify, EntityManagerInterface $entityManager, 
        TryoutRepository $TryoutRep, TryoutEnrolmentRepository $TryoutEnrolRep )
    {
        $this->slugger = $slugify;
        $this->em = $entityManager;
        $this->tryoutRep = $TryoutRep;
        $this->tryoutEnrolRep = $TryoutEnrolRep;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => array('setSlug'),
            'easy_admin.pre_update' => array('setSlug'),
            'easy_admin.post_update' => array('updateTryoutCounters'),
        );
    }

    public function setSlug(GenericEvent $event)
    {
        $entity = $event->getSubject();
        $force = $entity instanceof BlogPost;

        if (method_exists($entity, 'setSlug') and method_exists($entity, 'getTitle')) {
            if (is_null($entity->getSlug()) or $force) {
                $entity->setSlug($this->slugger->slugify($entity->getTitle()));
            } else {
                $entity->setSlug($this->slugger->slugify($entity->getSlug()));
            }
        } else {
            return;
        }
        $event['entity'] = $entity;
    }


    public function updateTryoutCounters(GenericEvent $event )
    {
        $entity = $event->getSubject();

        if (!($entity instanceof TryoutEnrolment)) return;

        $tryouts = $this->tryoutRep->findAll();
        //$tryouts = $this->tryoutRep->findTryouts(7);

        foreach( $tryouts as $tryout ) {
          $tryout->setNofEnrolments( $this->tryoutEnrolRep->countEnrolments($tryout) );
        }
        $this->tryoutRep->flush();

//        $event['entity'] = $entity;
    }

}
