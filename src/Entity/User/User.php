<?php

namespace App\Entity\User;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Bookmark;
use App\Entity\Country;
use App\Entity\Job\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\User\UserRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table("`user_user`")]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type')]
#[ORM\DiscriminatorMap([
    'candidate' => Candidate::class,
    'employer' => Employer::class
])]
#[UniqueEntity(fields: ['email', 'username'])]
#[ApiResource()]
/**
 * @Vich\Uploadable()
 */
abstract class User implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface 
{
    use TimestampableEntity;

    private ?string $type = '';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    protected ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    protected ?string $email = null;

    /**
     * @var array
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string|null The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?string $password = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $username = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $about = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;


    #[ORM\Column(nullable: true)]
    private ?string $avatarName = '';

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="avatars", fileNameProperty="avatarName")
     */
    private ?File $avatarFile = null;

    #[ORM\ManyToOne]
    private ?Category $category = null;

    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birth = null;

    #[ORM\Column(nullable: true)]
    private ?array $socialAccounts = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Bookmark::class, orphanRemoval: true)]
    private Collection $bookmarks;

    #[ORM\ManyToOne]
    private ?Country $country = null;

    #[ORM\Column(nullable: true, options: ['unsigned' => true, 'default' => 0])]
    private ?int $viewCount = null;


    public function __construct()
    {
        $this->bookmarks = new ArrayCollection();
    }

    public function isEqualTo(UserInterface $user): bool
    {
      return $this->getEmail() === $user->getUserIdentifier();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
      $this->id = $id;
      return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getAvatarName(): ?string
    {
        return $this->avatarName;
    }

    public function setAvatarName(?string $avatarName): self
    {
        $this->avatarName = $avatarName;

        return $this;
    }

    /**
     * Get the value of avatarFile
     */
    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    /**
     * Set the value of avatarFile
     *
     * @param File|null $avatarFile
     * @return  self
     */
    public function setAvatarFile(?File $avatarFile): \App\Entity\User\User
    {
        $this->avatarFile = $avatarFile;

        if(null !== $avatarFile) {
          $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }


    public function getBirth(): ?\DateTimeInterface
    {
        return $this->birth;
    }

    public function setBirth(?\DateTimeInterface $birth): self
    {
        $this->birth = $birth;

        return $this;
    }

    public function getSocialAccounts(): array
    {
        return $this->socialAccounts;
    }

    public function setSocialAccounts(?array $socialAccounts): self
    {
        $this->socialAccounts = $socialAccounts;

        return $this;
    }

    /**
     * @return Collection<int, Bookmark>
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    public function addBookmark(Bookmark $bookmark): self
    {
        if (!$this->bookmarks->contains($bookmark)) {
            $this->bookmarks[] = $bookmark;
            $bookmark->setUser($this);
        }

        return $this;
    }

    public function removeBookmark(Bookmark $bookmark): self
    {
        if ($this->bookmarks->removeElement($bookmark)) {
            // set the owning side to null (unless already changed)
            if ($bookmark->getUser() === $this) {
                $bookmark->setUser(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    public function setViewCount(int $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }
}
