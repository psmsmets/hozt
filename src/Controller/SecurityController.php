<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
//use Ambta\DoctrineEncryptBundle\Encryptors\EncryptorInterface;

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
/*
    protected $encryptor;
    
    public function __construct(EncryptorInterface $encryptor)
    {
        $this->encryptor = $encryptor;
    }
*/

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
                    ->setFrom(array($this->getParameter('app.mailer.from')=>$this->getParameter('app.mailer.name')))
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(UserChangePassword::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$encoder->isPasswordValid($user, $form->getData()['oldPassword'])) {

                $this->addFlash('danger', 'Je huidig wachtwoord is verkeerd.');
                return $this->redirectToRoute('app_change_password');

            }

            if (!preg_match('/'.User::PASSWORD_REGEX.'/', $form->getData()['plainPassword'])) {

                $this->addFlash('danger', 'Je nieuw wachtwoord voldoet niet aan de voorwaarden.');
                return $this->redirectToRoute('app_change_password');

            }

            if ($encoder->isPasswordValid($user, $form->getData()['plainPassword'])) {

                $this->addFlash('danger', 'Je nieuw wachtwoord mag niet gelijk zijn aan je oud wachtwoord.');
                return $this->redirectToRoute('app_change_password');

            }

            $password = $encoder->encodePassword($user, $form->getData()['plainPassword']);
            $user->setPassword($password);
            $userRepository->flush();
               
            $this->addFlash('success', 'Je wachtwoord is aangepast.');

            return $this->redirectToRoute('homepage');

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

        $token = (string) $request->query->get(User::PASSWORD_RESET, null);

        if (strlen($token) != 64) return $this->redirectToRoute('app_login');

        if ($user = $userRepository->findOneByToken($token, User::PASSWORD_RESET)) {

            $form = $this->createForm(UserResetPassword::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if (!preg_match('/'.User::PASSWORD_REGEX.'/', $form->getData()['plainPassword'])) {

                    $this->addFlash('danger', 'Je nieuw wachtwoord voldoet niet aan de voorwaarden.');
                    return $this->redirectToRoute('app_reset_password', [ User::PASSWORD_RESET => $token ]);

                }

                if ($encoder->isPasswordValid($user, $form->getData()['plainPassword'])) {

                    $this->addFlash('danger', 'Je nieuw wachtwoord mag niet gelijk zijn aan je oud wachtwoord.');
                    return $this->redirectToRoute('app_reset_password', [ User::PASSWORD_RESET => $token ]);

                }

                $password = $encoder->encodePassword($user, $form->getData()['plainPassword']);
                $user->setPassword($password);
                $user->expireSecret();
                $userRepository->flush();

                // send email
                $message = (new \Swift_Message())
                    ->setSubject('Nieuw wachtwoord ingesteld')
                    ->setFrom(array($this->getParameter('app.mailer.from')=>$this->getParameter('app.mailer.name')))
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

                return $this->redirectToRoute('app_login');

            } 

        } else {

            $this->addFlash('danger', 'De token is verlopen of niet correct.');
            return $this->redirectToRoute('app_login');

        }

        return $this->render('security/forms.html.twig', array( 
                'form' => $form->createView(),
                'title' => 'Wachtwoord instellen',
                'submit' => 'Bevestig je wachtwoord',
                'password_requirements' => User::PASSWORD_REQUIREMENTS,
            ));

    }

    /**
     * @Route("/gebruikersaccount-activeren", name="app_activate_user_account")
     */
    public function activate_user_account(): Response
    {
        return $this->render('security/activate.html.twig');
    }

}
