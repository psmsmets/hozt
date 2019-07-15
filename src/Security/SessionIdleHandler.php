<?php

namespace App\Security;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class SessionIdleHandler
{

    protected $session;
    protected $securityToken;
    protected $router;
    protected $security;
    protected $maxIdleTime;

    public function __construct(SessionInterface $session, RouterInterface $router, Security $security, $maxIdleTime = 0)
    {
        $this->session = $session;
        $this->router = $router;
        $this->security = $security;
        $this->maxIdleTime = $maxIdleTime;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {

            return;
        }

        if ($this->maxIdleTime > 0) {

            $this->session->start();
            $lapse = time() - $this->session->getMetadataBag()->getLastUsed();

            if ($lapse > $this->maxIdleTime) {

                $this->session->invalidate();
              
                if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {

                    $this->session->getFlashBag()->add('warning', 'Je sessie is verlopen wegens inactiviteit.');
                    $event->setResponse(new RedirectResponse($this->router->generate('security_logout')));

                }
            }
        }
    }

}
