<?php

namespace App\Entity;

use App\Repository\BookReadLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookReadLikeRepository::class)]
class BookReadLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookReadLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BookRead $book_read = null;

    #[ORM\ManyToOne(inversedBy: 'bookReadLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $is_liked = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookRead(): ?BookRead
    {
        return $this->book_read;
    }

    public function setBookRead(?BookRead $bookRead): static
    {
        $this->book_read = $bookRead;

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

    public function getIsLiked(): ?bool
    {
        return $this->is_liked;
    }

    public function setIsLiked(bool $is_liked): static
    {
        $this->is_liked = $is_liked;

        return $this;
    }
}
