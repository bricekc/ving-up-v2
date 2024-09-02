<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\SujetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SujetRepository::class)]
#[ApiResource(
    operations: [
        new get(
            normalizationContext: ['groups' => ['get_Sujet']]
        ),
        new getCollection(
            normalizationContext: ['groups' => ['get_Sujet']]
        ),
        new \ApiPlatform\Metadata\Post(
            security: "is_granted('ROLE_USER')"
        ),
        new delete(
            security: "is_granted('ROLE_ADMIN')"
        ),
    ]
)]
class Sujet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_Sujet'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_Sujet', 'set_Sujet'])]
    private ?string $intitule_sujet = null;

    #[ORM\OneToMany(mappedBy: 'sujet', targetEntity: Post::class)]
    #[Groups(['get_Sujet', 'set_Sujet'])]
    private Collection $posts;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['get_Sujet', 'set_Sujet'])]
    private ?\DateTimeInterface $date_last_update = null;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleSujet(): ?string
    {
        return $this->intitule_sujet;
    }

    public function setIntituleSujet(string $intitule_sujet): self
    {
        $this->intitule_sujet = $intitule_sujet;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setSujet($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getSujet() === $this) {
                $post->setSujet(null);
            }
        }

        return $this;
    }

    public function getDateLastUpdate(): ?\DateTimeInterface
    {
        return $this->date_last_update;
    }

    public function setDateLastUpdate(?\DateTimeInterface $date_last_update): self
    {
        $this->date_last_update = $date_last_update;

        return $this;
    }
}
