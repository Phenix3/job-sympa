<?php

namespace App\Entity;

use App\Entity\User\User;
use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[ORM\Table("`notification`")]
class Notification
{
    use TimestampableEntity;

    const CANDIDATE = 1;
    const EMPLOYER = 2;
    const ADMIN = 3;

    const notificationType = [
        self::JOB_APPLICATION_SUBMITTED     => 'APPLICATION SUBMITTED',
        self::MARK_JOB_FEATURED             => 'MARK JOB FEATURED',
        self::MARK_COMPANY_FEATURED         => 'MARK COMPANY FEATURED',
        self::CANDIDATE_SELECTED_FOR_JOB    => 'SELECTED FOR JOB',
        self::CANDIDATE_REJECTED_FOR_JOB    => 'REJECTED FOR JOB',
        self::CANDIDATE_SHORTLISTED_FOR_JOB => 'SHORTLISTED FOR JOB',
        self::NEW_EMPLOYER_REGISTERED       => 'EMPLOYER REGISTERED',
        self::NEW_CANDIDATE_REGISTERED      => 'CANDIDATE REGISTERED',
        self::EMPLOYER_PURCHASE_PLAN        => 'PURCHASE PLAN',
        self::FOLLOW_COMPANY                => 'FOLLOW COMPANY',
        self::FOLLOW_JOB                    => 'FOLLOW JOB',
        self::JOB_ALERT                     => 'JOB ALERT',
        self::MARK_COMPANY_FEATURED_ADMIN   => 'MARK COMPANY FEATURED',
        self::MARK_JOB_FEATURED_ADMIN       => 'MARK JOB FEATURED',
    ];

    const JOB_APPLICATION_SUBMITTED = 1;
    const MARK_JOB_FEATURED = 2;
    const MARK_COMPANY_FEATURED = 3;
    const CANDIDATE_SELECTED_FOR_JOB = 4;
    const CANDIDATE_REJECTED_FOR_JOB = 5;
    const CANDIDATE_SHORTLISTED_FOR_JOB = 6;
    const NEW_EMPLOYER_REGISTERED = 7;
    const NEW_CANDIDATE_REGISTERED = 8;
    const EMPLOYER_PURCHASE_PLAN = 9;
    const FOLLOW_COMPANY = 10;
    const FOLLOW_JOB = 11;
    const JOB_ALERT = 12;
    const MARK_COMPANY_FEATURED_ADMIN = 13;
    const MARK_JOB_FEATURED_ADMIN = 14;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column]
    private ?int $notificationFor = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeInterface $reatAt = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $target = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $channel = 'public';

    /**
     * @return string
     */
    public static function getNotificationForText(?int $type = null)
    {
        return self::notificationType[$type] ?: '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNotificationFor(): ?int
    {
        return $this->notificationFor;
    }

    public function setNotificationFor(int $notificationFor): self
    {
        $this->notificationFor = $notificationFor;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getReatAt(): ?\DateTimeImmutable
    {
        return $this->reatAt;
    }

    public function setReatAt(?\DateTimeImmutable $reatAt): self
    {
        $this->reatAt = $reatAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(?string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(?string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }
}
