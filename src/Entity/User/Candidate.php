<?php

namespace App\Entity\User;

use App\Entity\User\User;
use App\Repository\User\CandidateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate extends User
{
    
    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {  
    }

    public function setRoles(array $roles): self
    {
        $roles[] = 'ROLE_CANDIDATE';
        $this->roles = array_unique($roles);

        return $this;
    }
}
