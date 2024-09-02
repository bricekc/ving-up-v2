<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post as ActionPost;
use App\Repository\PostRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    operations: [
        new get(
            normalizationContext: ['groups' => ['get_Post']]
        ),
        new getCollection(
            normalizationContext: ['groups' => ['get_Post']]
        ),
        new put(
            normalizationContext: ['groups' => ['get_Post']],
            denormalizationContext: ['groups' => ['set_Post']],
            security: "is_granted('ROLE_USER') and object.getUser() == user"
        ),
        new ActionPost(
            denormalizationContext: ['groups' => ['set_Post']],
            security: "is_granted('ROLE_USER')"
        ),
        new patch(
            normalizationContext: ['groups' => ['get_Post']],
            denormalizationContext: ['groups' => ['set_Post']],
            security: "is_granted('ROLE_USER') and object.getUser() == user"
        ),
        new delete(
            security: "is_granted('ROLE_ADMIN') or (is_granted('ROLE_USER') and object.getUser() == user)"
        ),
    ]
)]
#[AsEntityListener(
    event: Events::prePersist,
    entity: Post::class,
)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_Sujet', 'get_Post'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['get_Sujet', 'get_Post', 'set_Post'])]
    private ?string $texte = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['get_Sujet', 'get_Post', 'set_Post'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['get_Sujet', 'get_Post', 'set_Post'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[Groups(['get_Sujet', 'get_Post', 'set_Post'])]
    private ?Sujet $sujet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getSujet(): ?Sujet
    {
        return $this->sujet;
    }

    public function setSujet(?Sujet $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }
}
