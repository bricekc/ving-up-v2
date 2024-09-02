<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ThematiqueRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ThematiqueRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            openapiContext : [
                'summary' => 'Récupère une Thématique par ID',
                'description' => 'Récupère une Thématique par ID',
                'responses' => [
                    '200' => [
                        'description' => 'Thématique récupérée avec succès',
                    ],
                    '404' => [
                        'description' => 'Thématique introuvable',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_thématique']],
        ),
        new GetCollection(
            openapiContext : [
                'summary' => 'Récupère toutes les Thématiques',
                'description' => 'Récupère la liste de toutes les Thématiques',
                'responses' => [
                    '200' => [
                        'description' => 'Thématiques récupérées avec succès',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_thématique']],
        ),
        ]
)]
class Thematique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_questionnaire'])]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'thematique', targetEntity: Question::class)]
    #[Groups(['get_thématique', 'get_questionnaire'])]
    private Collection $questions;

    #[ORM\ManyToMany(targetEntity: Questionnaire::class, mappedBy: 'thematiques')]
    #[Groups(['get_thématique'])]
    private Collection $questionnaires;

    #[ORM\OneToMany(mappedBy: 'thematique', targetEntity: Commentaire::class)]
    #[Groups(['get_thématique', 'get_questionnaire'])]
    private Collection $commentaires;

    #[ORM\Column(length: 255)]
    #[Groups(['get_thématique', 'get_questionnaire'])]
    private ?string $NomThematique = null;

    public function __toString()
    {
        return $this->NomThematique;
    }

    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function setCommentaires(Collection $commentaires): void
    {
        $this->commentaires = $commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
        }

        return $this;
    }

    /**
    @return Collection
     */
    public function getQuestionnaires(): Collection
    {
        return $this->questionnaires;
    }

    /**
    @param Collection $questionnaires
     */
    public function setQuestionnaires(Collection $questionnaires): void
    {
        $this->questionnaires = $questionnaires;
    }

    public function addQuestionnaire(Questionnaire $questionnaire): self
    {
        if (!$this->questionnaires->contains($questionnaire)) {
            $this->questionnaires[] = $questionnaire;
        }

        return $this;
    }

    public function removeQuestionnaire(Questionnaire $questionnaire): self
    {
        if ($this->questionnaires->contains($questionnaire)) {
            $this->questionnaires->removeElement($questionnaire);
        }

        return $this;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function setQuestions(Collection $questions): void
    {
        $this->questions = $questions;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomThematique(): ?string
    {
        return $this->NomThematique;
    }

    public function setNomThematique(string $NomThematique): self
    {
        $this->NomThematique = $NomThematique;

        return $this;
    }
}
