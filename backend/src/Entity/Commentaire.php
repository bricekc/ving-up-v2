<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            openapiContext : [
                'summary' => 'Récupère un Commentaire par ID',
                'description' => 'Récupère une Commentaire par ID',
                'responses' => [
                    '200' => [
                        'description' => 'Commentaire récupérée avec succès',
                    ],
                    '404' => [
                        'description' => 'Commentaire introuvable',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_commentaire']],
        ),
        new GetCollection(
            openapiContext : [
                'summary' => 'Récupère tous les Commentaires',
                'description' => 'Récupère la liste de tous les Commentaires',
                'responses' => [
                    '200' => [
                        'description' => 'Commentaires récupérées avec succès',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_commentaire']],
        ),
    ]
)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_questionnaire'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['get_commentaire', 'get_questionnaire'])]
    private ?string $commentaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\ManyToOne(targetEntity: Questionnaire::class, inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['get_commentaire'])]
    private $questionnaire;

    #[ORM\OneToOne(inversedBy: 'commentaire', targetEntity: Reponse::class)]
    #[Groups(['get_commentaire'])]
    private ?Reponse $reponse;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups(['get_commentaire', 'get_questionnaire'])]
    private array $notes = [];

    #[ORM\ManyToOne(targetEntity: Thematique::class, inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['get_commentaire'])]
    private ?Thematique $thematique;

    public function __toString(): string
    {
        return $this->commentaire;
    }

    public function getThematique(): ?Thematique
    {
        return $this->thematique;
    }

    public function setThematique(?Thematique $thematique): void
    {
        $this->thematique = $thematique;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(?Reponse $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getNotes(): array
    {
        return $this->notes;
    }

    public function setNotes(array $notes): self
    {
        $this->notes = $notes;

        return $this;
    }
}
