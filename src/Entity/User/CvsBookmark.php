<?php

namespace App\Entity\User;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Bookmark;
use App\Repository\User\CvsBookmarkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CvsBookmarkRepository::class)]
#[ApiResource()]
class CvsBookmark extends Bookmark
{

    #[ORM\ManyToOne(inversedBy: 'cvsBookmarks')]
    #[ORM\JoinColumn(nullable: true)]
    private ?CandidateCvs $cv = null;

    public function getCv(): ?CandidateCvs
    {
        return $this->cv;
    }

    public function setCv(?CandidateCvs $cv): self
    {
        $this->cv = $cv;

        return $this;
    }
}
