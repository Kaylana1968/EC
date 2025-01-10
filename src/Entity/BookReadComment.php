<?php

namespace App\Entity;

use App\Repository\BookReadCommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookReadCommentRepository::class)]
class BookReadComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookReadComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BookRead $book_read = null;

    #[ORM\ManyToOne(inversedBy: 'bookReadComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\Column(length: 2047)]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookRead(): ?BookRead
    {
        return $this->book_read;
    }

    public function setBookRead(?BookRead $book_read): static
    {
        $this->book_read = $book_read;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
