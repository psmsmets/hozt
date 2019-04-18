<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Ambta\DoctrineEncryptBundle\Encryptors\EncryptorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

# entities
use App\Entity\User;

# repositories
use App\Repository\UserRepository;

# forms
use App\Form\UserForgotPassword;
use App\Form\UserResetPassword;
use App\Form\UserChangePassword;

class SecurityController extends AbstractController
{

    protected $requestStack;
    protected $encryptor;
    
    public function __construct(RequestStack $requestStack, EncryptorInterface $encryptor)
    {
        $this->requestStack = $requestStack;
        $this->encryptor = $encryptor;
    }

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
    public function forgot_password(Request $request, UserRepository $userRepository, \Swift_Mailer $mailer ): Response
    {
        $form = $this->createForm(UserForgotPassword::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = $form->getData()['email'];

            if ($user = $userRepository->findOneByEmail($email)) {

                $token = $user->newResetPasswordToken();
                $userRepository->flush();

                $url = $this->get('router')->generate('app_reset_password', array(User::PASSWORD_RESET => $token));

                // send email
                $message = (new \Swift_Message())
                    ->setSubject('Instructies wachtwoord instellen')
                    ->setFrom(array('webmaster@hozt.be'=>'HoZT'))  // variable app.mailer.from
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'security/emails/forgot_password.html.twig',
                            array( 
                                'name' => strval($user), 
                                'url' => $url,
                            )
                        ),
                        'text/html'
                    );
                $sent = $mailer->send($message);

                $this->addFlash('success', 'Er is een email met de instructies onderweg als het adres ons bekend is.');
                
             }

            return $this->redirectToRoute('app_forgot_password');
        }
        return $this->render('security/forms.html.twig', array( 
                'form' => $form->createView(),
                'title' => 'Wachtwoord vergeten?',
                'submit' => 'Wachtwoord aanvragen',
            ));
    }

    /**
     * @Route("/wachtwoord-veranderen", name="app_change_password")
     */
    public function change_password(
            Request $request, 
            UserPasswordEncoderInterface $encoder,
            UserRepository $userRepository 
        ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Je moet ingelogd zijn om je wachtwoord aan te kunnen passen!');

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(UserChangePassword::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($encoder->isPasswordValid($user, $form->getData()['oldPassword'])) {

                if (preg_match('/'.User::PASSWORD_REGEX.'/', $form->getData()['plainPassword'])) {

                    if (!$encoder->isPasswordValid($user, $form->getData()['plainPassword'])) {

                        $password = $encoder->encodePassword($user, $form->getData()['plainPassword']);
                        $user->setPassword($password);
                        $userRepository->flush();
                
                        $this->addFlash('success', 'Je wachtwoord is aangepast.');

                        return $this->redirectToRoute('app_change_password');

                    } else {

                        $this->addFlash('danger', 'Je nieuw wachtwoord mag niet gelijk zijn aan je oude wachtwoord.');

                    }

                } else {

                    $this->addFlash('danger', 'Je nieuw wachtwoord voldoet niet aan de voorwaarden.');

                }

            } else {

                $this->addFlash('danger', 'Je huidig wachtwoord is verkeerd.');

            }

        }

        return $this->render('security/forms.html.twig', array( 
                'form' => $form->createView(),
                'title' => 'Wachtwoord veranderen',
                'submit' => 'Wachtwoord veranderen',
                'password_requirements' => User::PASSWORD_REQUIREMENTS,
            ));

    }

    /**
     * @Route("/wachtwoord-instellen", name="app_reset_password")
     */
    public function reset_password(
            Request $request, 
            UserPasswordEncoderInterface $encoder,
            UserRepository $userRepository,
            \Swift_Mailer $mailer
        ): Response
    {
        $request = $this->requestStack->getCurrentRequest();

        $token = (string) $request->query->get(User::PASSWORD_RESET, null);

        if (strlen($token) == 64) {

            if ($user = $userRepository->findOneByToken($token, User::PASSWORD_RESET)) {

                $form = $this->createForm(UserResetPassword::class);

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    if (preg_match('/'.User::PASSWORD_REGEX.'/', $form->getData()['plainPassword'])) {

                        $password = $encoder->encodePassword($user, $form->getData()['plainPassword']);
                        $user->setPassword($password);
                        $user->expireSecret();
                        $userRepository->flush();

                        // send email
                        $message = (new \Swift_Message())
                            ->setSubject('Nieuw wachtwoord ingesteld')
                            ->setFrom(array('webmaster@hozt.be'=>'HoZT'))  // variable app.mailer.from
                            ->setTo($user->getEmail())
                            ->setBody(
                                $this->renderView(
                                    'security/emails/reset_password.html.twig',
                                    array( 
                                    'name' => strval($user), 
                                    )
                                ),
                                'text/html'
                            );
                        $sent = $mailer->send($message);
                
                        $this->addFlash('success', 'Je wachtwoord is aangepast.');

                    } else {

                        $this->addFlash('danger', 'Je nieuw wachtwoord voldoet niet aan de voorwaarden.');

                    }

                } else {

                    return $this->render('security/forms.html.twig', array( 
                            'form' => $form->createView(),
                            'title' => 'Wachtwoord instellen',
                            'submit' => 'Bevestig je wachtwoord',
                            'password_requirements' => User::PASSWORD_REQUIREMENTS,
                        ));

                }

            } else {

                $this->addFlash('danger', 'De token is verlopen of niet correct.');

            }

        }

        return $this->redirectToRoute('app_login');

    }

    /**
     * @Route("/gebruikersaccount-activeren", name="app_activate_user_account")
     */
    public function activate_user_account(): Response
    {
        return $this->render('security/activate.html.twig');
    }

}
