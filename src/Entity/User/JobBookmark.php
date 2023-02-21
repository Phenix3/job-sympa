<?php

namespace App\Entity\User;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\Bookmark;
use App\Entity\Job\Job;
use App\Repository\User\JobBookmarkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: JobBookmarkRepository::class)]
#[ApiResource()]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'job' => 'exact', 'user' => 'exact'])]
#[UniqueEntity(fields: ['user', 'job'])]
class JobBookmark extends Bookmark
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'jobBookmarks', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Job $job = null;


    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }
}
