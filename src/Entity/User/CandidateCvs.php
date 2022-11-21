<?php

namespace App\Entity\User;

use App\Entity\Attachment;
use App\Repository\User\CandidateCvsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: CandidateCvsRepository::class)]
#[ORM\Table("`user_candidate_cvs`")]
class CandidateCvs
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cvs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidate $candidate = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Attachment $file = null;

    #[ORM\Column(nullable: true, options: ['default' => false])]
    private ?bool $isDefault = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $jobTitle = null;

    #[ORM\OneToMany(mappedBy: 'cv', targetEntity: CvsBookmark::class, orphanRemoval: true)]
    private Collection $cvsBookmarks;

    public function __construct()
    {
        $this->cvsBookmarks = new ArrayCollection();
    }

    public function isBookmarkedByUser(UserInterface $user): bool
    {
        foreach ($this->cvsBookmarks as $cvsBookmark) {
            /** @var CvsBookmark $cvsBookmark */
            if($cvsBookmark->getUser() === $user) return true;
        }
        return false;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getFile(): ?Attachment
    {
        return $this->file;
    }

    public function setFile(Attachment $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function isIsDefault(): ?bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(?bool $isDefault): self
    {
        $this->isDefault = $isDefault;

        return $this;
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

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * @return Collection<int, CvsBookmark>
     */
    public function getCvsBookmarks(): Collection
    {
        return $this->cvsBookmarks;
    }

    public function addCvsBookmark(CvsBookmark $cvsBookmark): self
    {
        if (!$this->cvsBookmarks->contains($cvsBookmark)) {
            $this->cvsBookmarks[] = $cvsBookmark;
            $cvsBookmark->setCv($this);
        }

        return $this;
    }

    public function removeCvsBookmark(CvsBookmark $cvsBookmark): self
    {
        if ($this->cvsBookmarks->removeElement($cvsBookmark)) {
            // set the owning side to null (unless already changed)
            if ($cvsBookmark->getCv() === $this) {
                $cvsBookmark->setCv(null);
            }
        }

        return $this;
    }
}
