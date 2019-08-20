<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserDetails;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager 
{
    private $entityManager;
    private $userRepository;
    private $status;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $encoder;
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
        $details = new UserDetails();
        $user->setDetails($details);

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setMobilePhone($mobile);
        $user->setRoles($roles);
        if ($this->isPasswordValid($password)) $user->setPassword( $this->passwordEncoder->encodePassword($user, $password) );
        $user->setVerified($verified);

        $this->entityManager->persist($user);
        $this->entityManager->persist($details);
        $this->entityManager->flush();

        //$user = $this->userRepository->findOneByEmail( $email, $enabled = null );
       
        $this->exitMessage = sprintf('New user created (%s #%d).', $user, $user->getId());
        return $user;

    }

    public function getExitMessage(): ?bool
    {
        return $this->exitMessage;
    }

    public function setActivity(User $user)
    {
        $user->updateLastActivity();

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function isPasswordValid(string $password): bool
    {
        return preg_match('/'.User::PASSWORD_REGEX.'/', $password);
    }
}
