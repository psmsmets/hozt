<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use Symfony\Component\Security\Core\Security;

use App\Entity\User;
use App\Service\UserManager;

class LastActivitySubscriber implements EventSubscriberInterface
{
    private $authChecker;
    private $security;
    private $userManager;

    public function __construct(Security $security, UserManager $userManager)
    {
        $this->security = $security;
        $this->userManager = $userManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => 'onResponse',
        );
    }

    public function onResponse(FilterResponseEvent $event)
    {
        $user = $this->security->getUser();
        if (!is_null($user)) $this->userManager->setActivity($user);
    }
}
