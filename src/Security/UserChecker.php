<?php

namespace App\Security;

use App\Exception\AccountDeletedException;
use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
//echo "<script>alert(\"checkPreAuth!\");</script>";
        if (!$user instanceof User) {
            return;
        }

    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

//echo "<script>alert(\"checkPostAuth!\");</script>";

        // user is not verified, show a generic message.
        if (!$user->isVerified()) {
            throw new CustomUserMessageAuthenticationException(
                'Your account is not yet verified.'
            );
        }

        // user is not activated, show a generic message.
        if (!$user->isEnabled()) {
            throw new CustomUserMessageAuthenticationException(
                'Your account is not active.'
            );
        }

        // user account is expired, the user may be notified
        if ($user->isPasswordExpired()) {
            throw new CustomUserMessageAuthenticationException(
                'Your password has been expired.'
            );
        }

    }
}
