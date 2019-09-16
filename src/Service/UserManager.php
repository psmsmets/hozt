<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserDetails;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Ambta\DoctrineEncryptBundle\Encryptors\EncryptorInterface;
use Twig\Environment;

class UserManager 
{
    private $em;
    private $userRepository;
    private $encoder;
    protected $encryptor;
    private $exitMessage;
    private $mailer;
    private $templating;
    private $defaultSender;

    public function __construct(
        $defaultSender, 
        EntityManagerInterface $em, UserRepository $userRepository, UserPasswordEncoderInterface $encoder,
        EncryptorInterface $encryptor, Environment $twig, \Swift_Mailer $mailer
    ){
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $encoder;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->defaultSender = $defaultSender;
        $this->encryptor = $encryptor;
        $this->exitMessage = null;
    }

    public function create(string $firstname, string $lastname, string $email, string $mobile, 
        array $roles = [], ?string $password = null, bool $verified = false ): ?User
    {
        // check if email is already used
        $user = $this->userRepository->findOneByEmail( $email, $enabled = null );
        if ($user) {
            $this->exitMessage = sprintf('A user already exists for that email address (%s #%d).', $user, $user->getId());
            return false;
        }

        // check if mobile phone is already used
        $user = $this->userRepository->findOneByMobilePhone( $mobile, $enabled = null );
        if ($user) {
            $this->exitMessage = sprintf('A user already exists for that mobile phone (%s #%d).', $user, $user->getId());
            return false;
        }

        // create a new user
        $user = new User();

        // create and link user details 
        $details = new UserDetails($user);

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setMobilePhone($mobile);
        $user->setRoles($roles);
        if ($this->isPasswordValid($password)) $user->setPassword( $this->passwordEncoder->encodePassword($user, $password) );
        $user->setVerified($verified);

        $this->em->persist($user);
        $this->em->persist($details);
        $this->em->flush();

        //$user = $this->userRepository->findOneByEmail( $email, $enabled = null );
       
        $this->exitMessage = sprintf('New user created (%s #%d).', $user, $user->getId());
        return $user;

    }

    public function invite(User $user): bool
    {
        if (!is_null($user->getLastActiveAt())) return false;
        return $this->email(
            $user,
            'Je account wacht op je', 
            'security/emails/user_invite.html.twig',
            array( 
                'name' => $user->getName(), 
                'email' => $user->getEmail(), 
            )
        );
    }

    public function email_verification(User $user): bool
    {
        if ($user->isVerified()) return false;

        $token = $user->newEmailVerificationToken();
        $this->em->flush();

        return $this->email(
            $user,
            'Account email verificatie', 
            'security/emails/verify_email.html.twig',
            array( 
                'name' => $user->getName(), 
                'link' => $this->get('router')->generate('security_verify_user', array(User::EMAIL_VERIFICATION => $token)),
            )
        );
    }

    public function password_reset(User $user): bool
    {
        $token = $user->newResetPasswordToken();
        $this->em->flush();

        return $this->email(
            $user,
            'Instructies wachtwoord instellen', 
            'security/emails/forgot_password.html.twig',
            array( 
                'name' => $user->getName(), 
                'link' => $this->get('router')->generate('security_reset_password', array(User::PASSWORD_RESET => $token)),
            )
        );
    }

    public function email(User $user, string $subject, string $template, array $data=null, bool $secondary=false): bool
    {
        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom($this->defaultSender)
            ->setTo($user->getEmail())
            ->setBody($this->twig->render($template, $data),'text/html');
        if ($secondary and !is_null($user->getUserDetails()->secondaryEmail())) $message->setBcc($user->getUserDetails()->secondaryEmail());
        return $this->mailer->send($message);
    }

    public function getExitMessage(): ?string
    {
        return $this->exitMessage;
    }

    public function setActivity(User $user)
    {
        $user->updateLastActivity();
        $this->em->persist($user);
        $this->em->flush();
    }

    public function isPasswordValid(string $password): bool
    {
        return preg_match('/'.User::PASSWORD_REGEX.'/', $password);
    }
}
