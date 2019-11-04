<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

use App\Entity\BlogPost;
use App\Entity\BlogCategory;
use App\Entity\Tryout;
use App\Entity\TryoutEnrolment;
use App\Entity\MemberGrouping;
use App\Entity\EnrolmentInput;

use App\Repository\TryoutRepository;
use App\Repository\TryoutEnrolmentRepository;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $em;

    public function __construct(\Cocur\Slugify\SlugifyInterface $slugify, EntityManagerInterface $em, 
        TryoutRepository $TryoutRep, TryoutEnrolmentRepository $TryoutEnrolRep )
    {
        $this->slugger = $slugify;
        $this->em = $em;
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

        if (method_exists($entity, 'setSlug'))
        {
            if ($entity instanceof MemberGrouping)
            {
                $entity->setSlug($this->slugger->slugify($entity->getFullname()));
            }
            elseif (is_null($entity->getSlug()) or $entity instanceof BlogPost)
            {
                if (method_exists($entity, 'getTitle')) {
                    $entity->setSlug($this->slugger->slugify($entity->getTitle()));
                }
                elseif (method_exists($entity, 'getName'))
                {
                    $entity->setSlug($this->slugger->slugify($entity->getName()));
                }
            }
            else
            {
                return;
            }
        }
        else
        {
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
