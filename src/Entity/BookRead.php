<?php

namespace App\Entity;

use App\Repository\BookReadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookReadRepository::class)]
#[ORM\UniqueConstraint(
    name: 'user_book_unique',
    columns: ['user_id', 'book_id']
)]
class BookRead
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $rating = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $is_read = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cover = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTime $created_at = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTime $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'bookReads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'bookReads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, BookReadLike>
     */
    #[ORM\OneToMany(targetEntity: BookReadLike::class, mappedBy: 'bookRead')]
    private Collection $bookReadLikes;

    /**
     * @var Collection<int, BookReadComment>
     */
    #[ORM\OneToMany(targetEntity: BookReadComment::class, mappedBy: 'book_read')]
    private Collection $bookReadComments;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->bookReadLikes = new ArrayCollection();
        $this->bookReadComments = new ArrayCollection();
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->getId(),
            'rating' => $this->getRating(),
            'description' => $this->getDescription(),
            'is_read' => $this->getIsRead(),
            'cover' => $this->getCover(),
            'created_at' => $this->getCreatedAt()?->format('Y-m-d H:i:s'),
            'updated_at' => $this->getUpdatedAt()?->format('Y-m-d H:i:s'),
            'book' => $this->getBook()->toArray(),
            'user' => $this->getUser()->toArray()
        ];

        return $data;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(?string $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): static
    {
        $this->is_read = $is_read;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
            $bookReadLike->setBookRead($this);
        }

        return $this;
    }

    public function removeBookReadLike(BookReadLike $bookReadLike): static
    {
        if ($this->bookReadLikes->removeElement($bookReadLike)) {
            // set the owning side to null (unless already changed)
            if ($bookReadLike->getBookRead() === $this) {
                $bookReadLike->setBookRead(null);
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
            $bookReadComment->setBookRead($this);
        }

        return $this;
    }

    public function removeBookReadComment(BookReadComment $bookReadComment): static
    {
        if ($this->bookReadComments->removeElement($bookReadComment)) {
            // set the owning side to null (unless already changed)
            if ($bookReadComment->getBookRead() === $this) {
                $bookReadComment->setBookRead(null);
            }
        }

        return $this;
    }
}
