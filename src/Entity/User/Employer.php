<?php

namespace App\Entity\User;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Job\Job;
use App\Entity\OwnershipType;
use App\Entity\User\User;
use App\Repository\User\EmployerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployerRepository::class)]
#[ORM\Table("`user_employer`")]
#[ApiResource()]
class Employer extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    protected ?int $id = null;

    /**
     * @var array
     */
    #[ORM\Column]
    private array $roles = ['ROLE_EMPLOYER'];


    #[ORM\Column(nullable: true)]
    private array $location = [];

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Job::class)]
    private Collection $jobs;

    #[ORM\ManyToOne]
    private ?OwnershipType $ownershipType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ceo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $establishedAt = null;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

    public function __serialize(): array
    {
      return [
            $this->id, 
            $this->email
        ];
    }

    public  function __unserialize(array $data): void
    {
      [$this->id, $this->email] = $data;
    }

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

    /**
     * @return Collection<int, Job>
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $job->setCompany($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getCompany() === $this) {
                $job->setCompany(null);
            }
        }

        return $this;
    }

    public function getOwnershipType(): ?OwnershipType
    {
        return $this->ownershipType;
    }

    public function setOwnershipType(?OwnershipType $ownershipType): self
    {
        $this->ownershipType = $ownershipType;

        return $this;
    }

    public function getCeo(): ?string
    {
        return $this->ceo;
    }

    public function setCeo(?string $ceo): self
    {
        $this->ceo = $ceo;

        return $this;
    }

    public function getEstablishedAt(): ?\DateTimeInterface
    {
        return $this->establishedAt;
    }

    public function setEstablishedAt(?\DateTimeInterface $establishedAt): self
    {
        $this->establishedAt = $establishedAt;

        return $this;
    }

}
