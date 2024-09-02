<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['get_user', 'get_fournisseur']]
        ),
        new getCollection(
            normalizationContext: ['groups' => ['get_user', 'get_fournisseur']]
        ),
        new patch(
            uriTemplate: '/fournisseur/verif/{id}',
            normalizationContext: ['groups' => ['get_user', 'verif']],
            denormalizationContext: ['groups' => ['verif']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new put(
            uriTemplate: '/fournisseur/verif/{id}',
            normalizationContext: ['groups' => ['get_user', 'verif']],
            denormalizationContext: ['groups' => ['verif']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new \ApiPlatform\Metadata\Post(
            normalizationContext: ['groups' => ['get_user']],
            denormalizationContext: ['groups' => ['modif_user']],
            security: "! is_granted('ROLE_USER')"
        ),
    ]
)]
class Fournisseur extends User
{
    /*
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    */

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['verif'])]
    private ?bool $verif = null;

    #[ORM\ManyToMany(targetEntity: TypeMateriel::class, inversedBy: 'fournisseurs')]
    #[Groups(['get_fournisseur'])]
    private Collection $type_materiel_propose;

    #[ORM\ManyToMany(targetEntity: TypeService::class, inversedBy: 'fournisseurs')]
    #[Groups(['get_fournisseur'])]
    private Collection $type_service_propose;

    public function __construct()
    {
        parent::__construct();
        $this->type_materiel_propose = new ArrayCollection();
        $this->type_service_propose = new ArrayCollection();
    }

    public function getVerif(): ?bool
    {
        return $this->verif;
    }

    public function setVerif(bool $verif): self
    {
        $this->verif = $verif;

        return $this;
    }

    /**
     * @return Collection<int, TypeMateriel>
     */
    public function getTypeMaterielPropose(): Collection
    {
        return $this->type_materiel_propose;
    }

    public function addTypeMaterielPropose(TypeMateriel $typeMaterielPropose): self
    {
        if (!$this->type_materiel_propose->contains($typeMaterielPropose)) {
            $this->type_materiel_propose->add($typeMaterielPropose);
        }

        return $this;
    }

    public function removeTypeMaterielPropose(TypeMateriel $typeMaterielPropose): self
    {
        $this->type_materiel_propose->removeElement($typeMaterielPropose);

        return $this;
    }

    /**
     * @return Collection<int, TypeService>
     */
    public function getTypeServicePropose(): Collection
    {
        return $this->type_service_propose;
    }

    public function addTypeServicePropose(TypeService $typeServicePropose): self
    {
        if (!$this->type_service_propose->contains($typeServicePropose)) {
            $this->type_service_propose->add($typeServicePropose);
        }

        return $this;
    }

    public function removeTypeServicePropose(TypeService $typeServicePropose): self
    {
        $this->type_service_propose->removeElement($typeServicePropose);

        return $this;
    }
}
