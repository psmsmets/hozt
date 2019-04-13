<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/wachtwoord-vergeten", name="app_forgot_password")
     */
    public function forgot_password(): Response
    {
        return $this->render('security/forgot.html.twig');
    }

    /**
     * @Route("/wachtwoord-veranderen", name="app_change_password")
     */
    public function change_password(): Response
    {
        return $this->render('security/change.html.twig');
    }

    /**
     * @Route("/wachtwoord-instellen", name="app_update_password")
     */
    public function reset_password(): Response
    {
        return $this->render('security/reset.html.twig');
    }

    /**
     * @Route("/gebruikersaccount-activeren", name="app_activate_user_account")
     */
    public function activate_user_account(): Response
    {
        return $this->render('security/activate.html.twig');
    }

}
