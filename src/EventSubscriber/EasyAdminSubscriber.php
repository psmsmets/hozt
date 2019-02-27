<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\EntityRepository;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\BlogPost;
use App\Entity\BlogCategory;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $em;

    public function __construct(\Cocur\Slugify\SlugifyInterface $slugify, EntityManagerInterface $entityManager)
    {
        $this->slugger = $slugify;
        $this->em = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => array('setSlug'),
            'easy_admin.pre_update' => array('setSlug'),
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

}
