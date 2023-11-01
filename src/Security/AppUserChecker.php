<?php

namespace App\Security;

use App\Entity\User\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AppUserChecker implements UserCheckerInterface
{
    /**
     * Undocumented function.
     *
     * @param UserInterface|User $user
     *
     * @return void
     */
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user->isVerified()) {
            throw new CustomUserMessageAccountStatusException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        // TODO: Implement checkPostAuth() method.
    }
}
