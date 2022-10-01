<?php

namespace App\Entity\User;

use App\Entity\User\User;
use App\Repository\User\EmployerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployerRepository::class)]
class Employer extends User
{

    /**
     * @var array
     */
    #[ORM\Column]
    private array $roles = ['ROLE_EMPLOYER'];


    #[ORM\Column(nullable: true)]
    private array $location = [];


    public function getProfileIdentifier(): string
    {
        return 'employer-'.$this->getId();
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    { 
    }


    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $roles[] = 'ROLE_EMPLOYER';
        $this->roles = array_unique($roles);

        return $this;
    }

    public function getLocation(): array
    {
        return $this->location;
    }

    public function setLocation(?array $location): self
    {
        $this->location = $location;

        return $this;
    }

}
