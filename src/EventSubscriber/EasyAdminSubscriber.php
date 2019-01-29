<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\EntityRepository;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\BlogPost;

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
//            'easy_admin.post_new' => array('setSequence'),
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

/*
    public function setSequence(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if (!method_exists($entity, 'setSequence')) {
            return;
        }
        $entityName = $this->em->getMetadataFactory()->getMetadataFor(get_class($entity))->getName();
        $repository = $this->em->getRepository($entityName);

        $sequence = (int) $repository
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence) as sequence')
            ->getQuery()
            ->getSingleScalarResult()+1;
        $entity->setSequence($sequence);
        $event['entity'] = $entity;
    }
*/

}
