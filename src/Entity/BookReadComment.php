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

    #[ORM\ManyToOne(targetEntity: BookRead::class, inversedBy: 'bookReadComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BookRead $book_read = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bookReadComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 2047)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTime $created_at = null;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->getId(),
            'bookRead' => $this->getBookRead()->toArray(),
            'user' => $this->getUser()->toArray(),
            'content' => $this->getContent(),
            'created_at' => $this->getCreatedAt()?->format('Y-m-d H:i:s'),
        ];

        return $data;
    }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
