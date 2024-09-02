<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TypeServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeServiceRepository::class)]
#[ApiResource(
    operations: [
        new get(
            normalizationContext: ['groups' => ['get_service']]
        ),
        new getCollection(
            normalizationContext: ['groups' => ['get_service']]
        ),
        new post(
            normalizationContext: ['groups' => ['get_service']],
            denormalizationContext: ['groups' => ['set_service']],
            security: "is_granted('ROLE_FOURNISSEUR') or is_granted('ROLE_ADMIN')"
        ),
        new put(
            normalizationContext: ['groups' => ['get_service']],
            denormalizationContext: ['groups' => ['modif_service']],
            security: "(is_granted('ROLE_FOURNISSEUR') and object.getFournisseurs()[0] == user) or is_granted('ROLE_ADMIN')"
        ),
        new patch(
            normalizationContext: ['groups' => ['get_service']],
            denormalizationContext: ['groups' => ['modif_service']],
            security: "(is_granted('ROLE_FOURNISSEUR') and object.getFournisseurs()[0] == user) or is_granted('ROLE_ADMIN')"
        ),
        new delete(
            security: "(is_granted('ROLE_FOURNISSEUR') and object.getFournisseurs()[0] == user) or is_granted('ROLE_ADMIN')"
        ),
    ]
)]
class TypeService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_service', 'get_fournisseur'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['get_service', 'set_service', 'modif_service', 'get_fournisseur'])]
    private ?string $description_service = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['get_service', 'set_service', 'modif_service', 'get_fournisseur'])]
    private ?string $intitule_service = null;

    #[ORM\ManyToMany(targetEntity: Fournisseur::class, mappedBy: 'type_service_propose')]
    #[Groups(['get_TypeService', 'set_service'])]
    private Collection $fournisseurs;

    #[ORM\ManyToOne(inversedBy: 'typeServices')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['get_service', 'set_service', 'modif_service', 'get_fournisseur'])]
    private ?Tag $tag = null;

    public function __construct()
    {
        $this->fournisseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription_Service(): ?string
    {
        return $this->description_service;
    }

    public function setDescription_Service(?string $description_service): self
    {
        $this->description_service = $description_service;

        return $this;
    }

    public function getIntitule_Service(): ?string
    {
        return $this->intitule_service;
    }

    public function setIntitule_Service(?string $intitule_service): self
    {
        $this->intitule_service = $intitule_service;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->description_service;
    }

    public function setDescriptionService(?string $description_service): self
    {
        $this->description_service = $description_service;

        return $this;
    }

    public function getIntituleService(): ?string
    {
        return $this->intitule_service;
    }

    public function setIntituleService(?string $intitule_service): self
    {
        $this->intitule_service = $intitule_service;

        return $this;
    }

    /**
     * @return Collection<int, Fournisseur>
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): self
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->add($fournisseur);
            $fournisseur->addTypeServicePropose($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): self
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            $fournisseur->removeTypeServicePropose($this);
        }

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
}
