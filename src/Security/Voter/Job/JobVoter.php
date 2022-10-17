<?php

namespace App\Security\Voter\Job;

use App\Entity\Job\Job;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class JobVoter extends Voter
{
    public const EDIT = 'JOB_EDIT';
    public const VIEW = 'JOB_VIEW';
    public const DELETE = 'JOB_DELETE';
    public const CAN_APPLY = 'JOB_CAN_APPLY';

    public function __construct(private Security $security)
    {}

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::CAN_APPLY])
            && $subject instanceof \App\Entity\Job\Job;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {


        /** @var Job $subject */

        switch ($attribute) {
            case self::DELETE:
            case self::EDIT:
                return $this->canEdit($subject, $token);
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                break;
            case self::CAN_APPLY:
                return $this->canApply($subject);
        }

        return false;
    }

    private function canEdit(Job $job, TokenInterface $token): bool
    {
        return $this->isAuthenticated($token) && $this->security->getUser() === $job->getCompany();
    }

    private function canApply(Job $job): bool
    {
        return $this->security->isGranted('ROLE_CANDIDATE');
    }

    private function isAuthenticated(TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        return $user instanceof UserInterface;
    }
}
