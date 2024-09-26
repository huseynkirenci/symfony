<?php

namespace App\Entity;

use App\Repository\MicroPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MicroPostRepository::class)]
class MicroPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 5, max: 255, minMessage: 'Title is to short, 5 charecters the minumum.')]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    // Yeni text alanı
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 5, max: 500)]

    private ?string $text = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'post', orphanRemoval: true)]
    private Collection $comments;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'liked')]
    private Collection $likedbBy;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->likedbBy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;
        return $this;
    }

    // Yeni eklenen text alanı için getter ve setter
    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikedbBy(): Collection
    {
        return $this->likedbBy;
    }

    public function addLikedbBy(User $likedbBy): static
    {
        if (!$this->likedbBy->contains($likedbBy)) {
            $this->likedbBy->add($likedbBy);
        }

        return $this;
    }

    public function removeLikedbBy(User $likedbBy): static
    {
        $this->likedbBy->removeElement($likedbBy);

        return $this;
    }
}
