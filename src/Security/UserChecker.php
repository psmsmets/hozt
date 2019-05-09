<?php

namespace App\Security;

use App\Exception\AccountDeletedException;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
        // user is not verified, show a generic message.
        if (!$user->isVerified()) {
            throw new CustomUserMessageAuthenticationException(
                'Je account is nog niet geverifieerd.'
            );
        }

        // user is not activated, show a generic message.
        if (!$user->isEnabled()) {
            throw new CustomUserMessageAuthenticationException(
                'Je account is niet actief.'
            );
        }

        // user account is expired, the user may be notified
        if ($user->isPasswordExpired()) {
            throw new CustomUserMessageAuthenticationException(
                'Je wachtwoord is verlopen.'
            );
        }

    }
}
