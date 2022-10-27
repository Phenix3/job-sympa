<?php

namespace App\Entity\User;

use App\Entity\Job\Application;
use App\Entity\Job\Type;
use App\Entity\User\User;
use App\Repository\User\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
#[ORM\Table("`user_candidate`")]
class Candidate extends User
{

    /**
     * @var array
     */
    #[ORM\Column]
    private array $roles = ['ROLE_CANDIDATE'];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jobTitle = null;

    #[ORM\ManyToOne]
    private ?Type $jobType = null;

    #[ORM\Column(nullable: true)]
    private ?int $experience = null;

    #[ORM\OneToMany(mappedBy: 'candidate', targetEntity: CandidateSkill::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $skills;

    #[ORM\OneToMany(mappedBy: 'candidate', targetEntity: CandidateCvs::class, orphanRemoval: true)]
    private Collection $cvs;

    #[ORM\OneToMany(mappedBy: 'candidate', targetEntity: Application::class)]
    private Collection $applications;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->cvs = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }


    public function serialize()
    {
      return serialize([$this->id, $this->email]);
    }

    public  function unserialize($data)
    {
      [$this->id, $this->email] = unserialize($data, ['allowed_classes' => false]);
    }

    public function getProfileIdentifier(): string
    {
        return 'candidate-'.$this->getId();
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
        $roles[] = 'ROLE_CANDIDATE';
        $this->roles = array_unique($roles);

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getJobType(): ?Type
    {
        return $this->jobType;
    }

    public function setJobType(?Type $jobType): self
    {
        $this->jobType = $jobType;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * @return Collection<int, CandidateSkill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(CandidateSkill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setCandidate($this);
        }

        return $this;
    }

    public function removeSkill(CandidateSkill $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getCandidate() === $this) {
                $skill->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CandidateCvs>
     */
    public function getCvs(): Collection
    {
        return $this->cvs;
    }

    public function addCv(CandidateCvs $cv): self
    {
        if (!$this->cvs->contains($cv)) {
            $this->cvs[] = $cv;
            $cv->setCandidate($this);
        }

        return $this;
    }

    public function removeCv(CandidateCvs $cv): self
    {
        if ($this->cvs->removeElement($cv)) {
            // set the owning side to null (unless already changed)
            if ($cv->getCandidate() === $this) {
                $cv->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setCandidate($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getCandidate() === $this) {
                $application->setCandidate(null);
            }
        }

        return $this;
    }
}
