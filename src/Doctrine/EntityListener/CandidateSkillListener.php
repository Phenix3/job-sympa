<?php

namespace App\Doctrine\EntityListener;

use App\Entity\User\CandidateSkill;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CandidateSkillListener
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {}

    public function prePersist(CandidateSkill $candidateSkill, LifecycleEventArgs $args): void
    {
        $candidateSkill
            ->setCandidate($this->tokenStorage->getToken()->getUser())
        ;
    }
}