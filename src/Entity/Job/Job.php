<?php

namespace App\Entity\Job;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\Employer;
use App\Entity\Country;
use App\Entity\User\JobBookmark;
use App\Repository\Job\JobRepository;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: JobRepository::class)]
#[ORM\Table("`job_job`")]
#[ApiResource(
    normalizationContext: ['groups' => ['read:job:collection']]
)]
class Job
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    #[Groups(['read:job:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:job:collection'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Gedmo\Slug(fields: ['title'])]
    #[Groups(['read:job:collection'])]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'jobs', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'job_job_job_category')]
    #[Groups(['read:job:collection'])]
    private Collection $categories;

    #[ORM\ManyToOne(fetch: "EAGER")]
    #[Groups(['read:job:collection'])]
    private ?Type $type = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:job:collection'])]
    private ?string $responsibilities = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:job:collection'])]
    private ?string $education = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:job:collection'])]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read:job:collection'])]
    private ?string $otherBenefits = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:job:collection'])]
    private ?int $experience = null;

    #[ORM\Column()]
    #[Groups(['read:job:collection'])]
    private ?int $salaryMin = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:job:collection'])]
    private ?int $salaryMax = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read:job:collection'])]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:job:collection'])]
    private ?string $requirements = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['read:job:collection'])]
    private ?\DateTimeInterface $publishedAt = null;

    #[ORM\ManyToOne]
    #[Groups(['read:job:collection'])]
    private ?Country $country = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fullAddress = null;

    #[ORM\ManyToMany(targetEntity: Skill::class, cascade: ['persist'])]
    #[ORM\JoinTable(name: 'job_job_job_skill')]
    private Collection $requiredSkills;

    #[ORM\OneToMany(mappedBy: 'job', targetEntity: Application::class)]
    #[Groups(['read:job'])]
    private Collection $applications;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    private ?Employer $company = null;

    #[ORM\OneToMany(mappedBy: 'job', targetEntity: JobBookmark::class, orphanRemoval: true)]
    private Collection $jobBookmarks;

    #[ORM\Column(nullable: true, options: ['default' => false])]
    private ?bool $isFreelance = null;

    #[ORM\Column(nullable: true, options: ['default' => false])]
    private ?bool $isSuspended = null;

    #[ORM\Column(nullable: true, options: ['default' => false])]
    private ?bool $isCreatedByAdmin = null;

    
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->requiredSkills = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->jobBookmarks = new ArrayCollection();
    }

    public function isActive(): bool
    {
        return Carbon::now()->gte($this->deadline);
    }

    public function isBookmarkedByUser(UserInterface $user): bool
    {
        foreach ($this->jobBookmarks as $jobBookmark) {
            /** @var JobBookmark $jobBookmark */
            if($jobBookmark->getUser() === $user) return true;
        }
        return false;
    }

    public function isAppliedByUser(UserInterface $user): bool
    {
        foreach ($this->applications as $application) {
            /** @var Application $application */
            if($application->getCandidate() === $user) return true;
        }
        return false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getResponsibilities(): ?string
    {
        return $this->responsibilities;
    }

    public function setResponsibilities(string $responsibilities): self
    {
        $this->responsibilities = $responsibilities;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOtherBenefits(): ?string
    {
        return $this->otherBenefits;
    }

    public function setOtherBenefits(?string $otherBenefits): self
    {
        $this->otherBenefits = $otherBenefits;

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

    public function getSalaryMin(): ?int
    {
        return $this->salaryMin;
    }

    public function setSalaryMin(int $salaryMin): self
    {
        $this->salaryMin = $salaryMin;

        return $this;
    }

    public function getSalaryMax(): ?int
    {
        return $this->salaryMax;
    }

    public function setSalaryMax(?int $salaryMax): self
    {
        $this->salaryMax = $salaryMax;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getRequirements(): ?string
    {
        return $this->requirements;
    }

    public function setRequirements(string $requirements): self
    {
        $this->requirements = $requirements;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getFullAddress(): ?string
    {
        return $this->fullAddress;
    }

    public function setFullAddress(?string $fullAddress): self
    {
        $this->fullAddress = $fullAddress;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getRequiredSkills(): Collection
    {
        return $this->requiredSkills;
    }

    public function addRequiredSkill(Skill $requiredSkill): self
    {
        if (!$this->requiredSkills->contains($requiredSkill)) {
            $this->requiredSkills[] = $requiredSkill;
        }

        return $this;
    }

    public function removeRequiredSkill(Skill $requiredSkill): self
    {
        $this->requiredSkills->removeElement($requiredSkill);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

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
            $application->setJob($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getJob() === $this) {
                $application->setJob(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Employer
    {
        return $this->company;
    }

    public function setCompany(?Employer $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, JobBookmark>
     */
    public function getJobBookmarks(): Collection
    {
        return $this->jobBookmarks;
    }

    public function addJobBookmark(JobBookmark $jobBookmark): self
    {
        if (!$this->jobBookmarks->contains($jobBookmark)) {
            $this->jobBookmarks[] = $jobBookmark;
            $jobBookmark->setJob($this);
        }

        return $this;
    }

    public function removeJobBookmark(JobBookmark $jobBookmark): self
    {
        if ($this->jobBookmarks->removeElement($jobBookmark)) {
            // set the owning side to null (unless already changed)
            if ($jobBookmark->getJob() === $this) {
                $jobBookmark->setJob(null);
            }
        }

        return $this;
    }

    public function isIsFreelance(): ?bool
    {
        return $this->isFreelance;
    }

    public function setIsFreelance(bool $isFreelance): self
    {
        $this->isFreelance = $isFreelance;

        return $this;
    }

    public function isIsSuspended(): ?bool
    {
        return $this->isSuspended;
    }

    public function setIsSuspended(bool $isSuspended): self
    {
        $this->isSuspended = $isSuspended;

        return $this;
    }

    public function isIsCreatedByAdmin(): ?bool
    {
        return $this->isCreatedByAdmin;
    }

    public function setIsCreatedByAdmin(bool $isCreatedByAdmin): self
    {
        $this->isCreatedByAdmin = $isCreatedByAdmin;

        return $this;
    }
}
