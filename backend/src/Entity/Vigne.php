<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\VigneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VigneRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            openapiContext: [
                'summary' => "récupérer des données d'une vigne par ID",
                'description' => "récupérer données d'une vigne par ID",
            ],
            normalizationContext : ['groups' => ['get_vigne']]
        ),
        new GetCollection(
            openapiContext: [
                'summary' => 'Récupère toutes les données des vignes',
                'description' => 'Récupère toutes les données des vignes',
            ],
            normalizationContext: ['groups' => ['get_vigne']],
        ),
        new Patch(
            openapiContext: [
                'summary' => 'Modification de la superficie',
                'description' => 'Modification de la superficie',
            ],
            normalizationContext: ['groups' => ['get_vigne']],
            denormalizationContext: ['groups' => ['set_vigne']],
            security: "is_granted('ROLE_USER') and object.getViticulteur() == user"
        ),
        new delete(
            security: "is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') and object.getViticulteur() == user"
        ),
        new \ApiPlatform\Metadata\Post(
            normalizationContext: ['groups' => ['get_vigne']],
            denormalizationContext: ['groups' => ['set_vigne']],
            security: "is_granted('ROLE_USER')"
        ),
    ]
)]
class Vigne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_vigne'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['get_vigne', 'set_vigne'])]
    private ?int $superficie = null;

    #[Groups(['get_vigne', 'set_vigne'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    #[Groups(['get_vigne', 'set_vigne'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'vignes')]
    #[Groups(['get_vigne'])]
    private ?Viticulteur $viticulteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuperficie(): ?int
    {
        return $this->superficie;
    }

    public function setSuperficie(?int $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getViticulteur(): ?Viticulteur
    {
        return $this->viticulteur;
    }

    public function setViticulteur(?Viticulteur $viticulteur): self
    {
        $this->viticulteur = $viticulteur;

        return $this;
    }
}
