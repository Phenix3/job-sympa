<?php

namespace App\Doctrine\EntityListener;

use App\Entity\User\CandidateCvs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CandidateCvListener
{
    public function __construct(private TokenStorageInterface $tokenStorage) {}

    public function prePersist(CandidateCvs $candidateCvs, LifecycleEventArgs $args): void
    {
        $candidateCvs->setCandidate($this->tokenStorage->getToken()->getUser());
    }
}