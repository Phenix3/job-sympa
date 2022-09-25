<?php

namespace App\Entity\User;

use App\Entity\User\User;
use App\Repository\User\EmployerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployerRepository::class)]
class Employer extends User
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
        $roles[] = 'ROLE_EMPLOYER';
        $this->roles = array_unique($roles);

        return $this;
    }

}
