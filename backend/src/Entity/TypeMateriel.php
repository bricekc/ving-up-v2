<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TypeMaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeMaterielRepository::class)]
#[ApiResource(
    operations: [
        new get(
            normalizationContext: ['groups' => ['get_materiel']]
        ),
        new getCollection(
            normalizationContext: ['groups' => ['get_materiel']]
        ),
        new post(
            normalizationContext: ['groups' => ['get_materiel']],
            denormalizationContext: ['groups' => ['set_materiel']],
            security: "is_granted('ROLE_FOURNISSEUR') or is_granted('ROLE_ADMIN')"
        ),
        new put(
            normalizationContext: ['groups' => ['get_materiel']],
            denormalizationContext: ['groups' => ['modif_materiel']],
            security: "(is_granted('ROLE_FOURNISSEUR') and object.getFournisseurs()[0] == user) or is_granted('ROLE_ADMIN')"
        ),
        new patch(
            normalizationContext: ['groups' => ['get_materiel']],
            denormalizationContext: ['groups' => ['modif_materiel']],
            security: "(is_granted('ROLE_FOURNISSEUR') and object.getFournisseurs()[0] == user) or is_granted('ROLE_ADMIN')"
        ),
        new delete(
            security: "(is_granted('ROLE_FOURNISSEUR') and object.getFournisseurs()[0] == user) or is_granted('ROLE_ADMIN')"
        ),
    ]
)]
class TypeMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_materiel', 'get_fournisseur'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['get_materiel', 'set_materiel', 'modif_materiel', 'get_fournisseur'])]
    private ?string $description_materiel = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['get_materiel', 'set_materiel', 'modif_materiel', 'get_fournisseur'])]
    private ?string $intitule_materiel = null;

    #[ORM\ManyToMany(targetEntity: Fournisseur::class, mappedBy: 'type_materiel_propose')]
    #[Groups(['get_materiel', 'set_materiel'])]
    private Collection $fournisseurs;

    #[ORM\ManyToOne(inversedBy: 'typeMateriels')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['get_materiel', 'set_materiel', 'modif_materiel', 'get_fournisseur'])]
    private ?Tag $tag = null;

    public function __construct()
    {
        $this->fournisseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription_materiel(): ?string
    {
        return $this->description_materiel;
    }

    public function setDescription_materiel(?string $description_materiel): TypeMateriel
    {
        $this->description_materiel = $description_materiel;

        return $this;
    }

    public function getIntitule_materiel(): ?string
    {
        return $this->intitule_materiel;
    }

    public function setIntitule_materiel(?string $intitule_materiel): TypeMateriel
    {
        $this->intitule_materiel = $intitule_materiel;

        return $this;
    }

    public function getDescriptionMateriel(): ?string
    {
        return $this->description_materiel;
    }

    public function setDescriptionMateriel(?string $description_materiel): TypeMateriel
    {
        $this->description_materiel = $description_materiel;

        return $this;
    }

    public function getIntituleMateriel(): ?string
    {
        return $this->intitule_materiel;
    }

    public function setIntituleMateriel(?string $intitule_materiel): TypeMateriel
    {
        $this->intitule_materiel = $intitule_materiel;

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
            $fournisseur->addTypeMaterielPropose($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): self
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            $fournisseur->removeTypeMaterielPropose($this);
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
