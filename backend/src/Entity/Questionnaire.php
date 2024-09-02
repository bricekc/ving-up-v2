<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionnaireRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            openapiContext: [
                'summary' => 'Récupère un questionnaire par ID',
                'description' => "Récupère un questionnaire par ID en faisant attention à l'accéssibilité",
                'responses' => [
                    '200' => [
                        'description' => 'Questionnaire récupéré avec succès',
                    ],
                    '401' => [
                        'description' => 'Non autorisé',
                    ],
                    '403' => [
                        'description' => 'Accès refusé',
                    ],
                    '404' => [
                        'description' => 'Questionnaire introuvable',
                    ],
                ],
            ],
            normalizationContext: ['groups' => ['get_questionnaire']],
            security: "object.isPublic() === true or (is_granted('IS_AUTHENTICATED_FULLY') and (is_granted('ROLE_ADMIN') or is_granted('ROLE_VITICULTEUR')) and object.isPublic() === false)"
        ),
        new GetCollection(
            openapiContext: [
                'summary' => 'Récupère la liste de tous les questionnaires.',
                'description' => "Récupère l'enssemble des questionnaires, peut êre utilisé pour afficher tous les questionnaires sur une page.",
                'responses' => [
                    '200' => [
                        'description' => 'Liste des questionnaires récupérée avec succès',
                    ],
                ],
            ],
            normalizationContext: ['groups' => ['get_questionnaire_collection']]
        ),
]
)]
class Questionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_questionnaire', 'get_questionnaire_collection'])]
    private ?string $intitule_questionnaire = null;

    #[ORM\OneToMany(mappedBy: 'questionnaire', targetEntity: ResultatQuestionnaire::class, orphanRemoval: true)]
    private Collection $resultatQuestionnaires;

    #[ORM\OneToMany(mappedBy: 'questionnaire', targetEntity: Question::class)]
    #[Groups(['get_questionnaire'])]
    private Collection $questions;

    #[ORM\Column]
    #[Groups(['get_questionnaire', 'get_questionnaire_collection'])]
    private ?bool $public = true;

    #[ORM\ManyToMany(targetEntity: Thematique::class, inversedBy: 'questionnaires')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['get_questionnaire'])]
    private $thematiques;

    #[ORM\OneToMany(mappedBy: 'questionnaire', targetEntity: Commentaire::class, orphanRemoval: true)]
    #[Groups(['get_questionnaire'])]
    private Collection $commentaires;

    public function __construct()
    {
        $this->resultatQuestionnaires = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->thematiques = new ArrayCollection();
    }

    public function setResultatQuestionnaires(ArrayCollection|Collection $resultatQuestionnaires): void
    {
        $this->resultatQuestionnaires = $resultatQuestionnaires;
    }

    public function setQuestions(ArrayCollection|Collection $questions): void
    {
        $this->questions = $questions;
    }

    public function setThematiques(?Collection $thematiques): void
    {
        $this->thematiques = $thematiques;
    }

    public function setCommentaires(ArrayCollection|Collection $commentaires): void
    {
        $this->commentaires = $commentaires;
    }

    public function getThematiques(): Collection
    {
        return $this->thematiques;
    }

    /**
     * @return $this
     */
    public function addThematique(Thematique $thematique): self
    {
        if (!$this->thematiques->contains($thematique)) {
            $this->thematiques->add($thematique);
            $thematique->addQuestionnaire($this);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeThematique(Thematique $thematique): self
    {
        if ($this->thematiques->contains($thematique)) {
            $this->thematiques->removeElement($thematique);
            $thematique->removeQuestionnaire($this);
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleQuestionnaire(): ?string
    {
        return $this->intitule_questionnaire;
    }

    public function setIntituleQuestionnaire(string $intitule_questionnaire): self
    {
        $this->intitule_questionnaire = $intitule_questionnaire;

        return $this;
    }

    /**
     * @return Collection<int, ResultatQuestionnaire>
     */
    public function getResultatQuestionnaires(): Collection
    {
        return $this->resultatQuestionnaires;
    }

    public function addResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if (!$this->resultatQuestionnaires->contains($resultatQuestionnaire)) {
            $this->resultatQuestionnaires->add($resultatQuestionnaire);
            $resultatQuestionnaire->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if ($this->resultatQuestionnaires->removeElement($resultatQuestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($resultatQuestionnaire->getQuestionnaire() === $this) {
                $resultatQuestionnaire->setQuestionnaire(null);
            }
        }

        return $this;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuestionnaire() === $this) {
                $question->setQuestionnaire(null);
            }
        }

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getQuestionnaire() === $this) {
                $commentaire->setQuestionnaire(null);
            }
        }

        return $this;
    }
}
