<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, BookRead>
     */
    #[ORM\OneToMany(targetEntity: BookRead::class, mappedBy: 'user')]
    private Collection $bookReads;

    /**
     * @var Collection<int, BookReadLike>
     */
    #[ORM\OneToMany(targetEntity: BookReadLike::class, mappedBy: 'user')]
    private Collection $bookReadLikes;

    /**
     * @var Collection<int, BookReadComment>
     */
    #[ORM\OneToMany(targetEntity: BookReadComment::class, mappedBy: 'user')]
    private Collection $bookReadComments;

    public function __construct()
    {
        $this->bookReads = new ArrayCollection();
        $this->bookReadLikes = new ArrayCollection();
        $this->bookReadComments = new ArrayCollection();
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'roles' => $this->getRoles(),
        ];

        return $data;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, BookRead>
     */
    public function getBookReads(): Collection
    {
        return $this->bookReads;
    }

    public function addBookRead(BookRead $bookRead): static
    {
        if (!$this->bookReads->contains($bookRead)) {
            $this->bookReads->add($bookRead);
            $bookRead->setUser($this);
        }

        return $this;
    }

    public function removeBookRead(BookRead $bookRead): static
    {
        if ($this->bookReads->removeElement($bookRead)) {
            // set the owning side to null (unless already changed)
            if ($bookRead->getUser() === $this) {
                $bookRead->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookReadLike>
     */
    public function getBookReadLikes(): Collection
    {
        return $this->bookReadLikes;
    }

    public function addBookReadLike(BookReadLike $bookReadLike): static
    {
        if (!$this->bookReadLikes->contains($bookReadLike)) {
            $this->bookReadLikes->add($bookReadLike);
            $bookReadLike->setUser($this);
        }

        return $this;
    }

    public function removeBookReadLike(BookReadLike $bookReadLike): static
    {
        if ($this->bookReadLikes->removeElement($bookReadLike)) {
            // set the owning side to null (unless already changed)
            if ($bookReadLike->getUser() === $this) {
                $bookReadLike->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookReadComment>
     */
    public function getBookReadComments(): Collection
    {
        return $this->bookReadComments;
    }

    public function addBookReadComment(BookReadComment $bookReadComment): static
    {
        if (!$this->bookReadComments->contains($bookReadComment)) {
            $this->bookReadComments->add($bookReadComment);
            $bookReadComment->setUser($this);
        }

        return $this;
    }

    public function removeBookReadComment(BookReadComment $bookReadComment): static
    {
        if ($this->bookReadComments->removeElement($bookReadComment)) {
            // set the owning side to null (unless already changed)
            if ($bookReadComment->getUser() === $this) {
                $bookReadComment->setUser(null);
            }
        }

        return $this;
    }
}
