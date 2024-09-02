<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Repository\ViticulteurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ViticulteurRepository::class)]
#[ApiResource(
    operations: [
        new getCollection(
            normalizationContext: ['groups' => ['get_user']]
        ),
        new patch(
            normalizationContext: ['groups' => ['get_user']],
            denormalizationContext: ['groups' => ['modif_user']],
            security: "is_granted('ROLE_VITICULTEUR') and object == user"
        ),
        new put(
            normalizationContext: ['groups' => ['get_user']],
            denormalizationContext: ['groups' => ['modif_user']],
            security: "is_granted('ROLE_VITICULTEUR') and object == user"
        ),
        new patch(
            uriTemplate: '/viticulteur/verif/{id}',
            normalizationContext: ['groups' => ['get_user', 'verif']],
            denormalizationContext: ['groups' => ['verif']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new put(
            uriTemplate: '/viticulteur/verif/{id}',
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
class Viticulteur extends User
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

    #[ORM\Column(length: 14, nullable: false)]
    #[Groups(['get_user', 'modif_user', 'get_vigne'])]
    #[ApiProperty(writable: true)]
    private ?string $num_siret = null;

    #[ORM\OneToMany(mappedBy: 'viticulteur', targetEntity: Vigne::class)]
    protected Collection $vignes;

    #[ORM\OneToMany(mappedBy: 'viticulteur', targetEntity: ResultatQuestionnaire::class, orphanRemoval: true)]
    private Collection $resultatQuestionnaires;

    public function __construct()
    {
        parent::__construct();
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

    public function getNumSiret(): ?string
    {
        return $this->num_siret;
    }

    public function setNumSiret(string $num_siret): self
    {
        $this->num_siret = $num_siret;

        return $this;
    }

    public function getResultatQuestionnaires(): Collection
    {
        return $this->resultatQuestionnaires;
    }

    public function addResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if (!$this->resultatQuestionnaires->contains($resultatQuestionnaire)) {
            $this->resultatQuestionnaires->add($resultatQuestionnaire);
            $resultatQuestionnaire->setViticulteur($this);
        }

        return $this;
    }

    public function removeResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if ($this->resultatQuestionnaires->removeElement($resultatQuestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($resultatQuestionnaire->getViticulteur() === $this) {
                $resultatQuestionnaire->setViticulteur(null);
            }
        }

        return $this;
    }
}
