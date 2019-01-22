<?php

namespace App\Listener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class LogoutListener implements LogoutHandlerInterface
{

    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return;
        } 
        $user->eraseCredentials();        
        $user->setIsActive(false);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
    }
}
