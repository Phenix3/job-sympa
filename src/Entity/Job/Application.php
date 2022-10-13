<?php

namespace App\Entity\Job;

use App\Repository\Job\ApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use \App\Entity\Job\Job;
use \App\Entity\User\Candidate;
use \App\Entity\User\CandidateCvs;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use http\Exception\InvalidArgumentException;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[UniqueEntity(fields: ['job', 'candidate'], message: 'ui.validator.already_applied_for_job')]
class Application
{
    use TimestampableEntity;

    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_PENDING = 'pending';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?Job $job = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?Candidate $candidate = null;

    #[ORM\ManyToOne]
    private ?CandidateCvs $cv = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(length: 255, options: ['default' => self::STATUS_PENDING])]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
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

    public function getCv(): ?CandidateCvs
    {
        return $this->cv;
    }

    public function setCv(?CandidateCvs $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, [static::STATUS_PENDING, static::STATUS_ACCEPTED, static::STATUS_REJECTED], true)) {
            throw new InvalidArgumentException(sprintf("Invalid status. Allowed is one of [%s, %s, %s]", static::STATUS_REJECTED, static::STATUS_ACCEPTED, static::STATUS_PENDING));
        }

        $this->status = $status;

        return $this;
    }
}
