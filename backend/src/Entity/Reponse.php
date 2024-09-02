<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
#[ApiResource(
    operations : [
        new Get(
            openapiContext : [
                'summary' => 'Récupère une réponse par ID',
                'description' => 'Récupère une question par ID',
                'responses' => [
                    '200' => [
                        'description' => 'Réponse récupérée avec succès',
                    ],
                    '404' => [
                        'description' => 'Réponse introuvable',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_reponse']],
        ),
        new GetCollection(
            openapiContext : [
                'summary' => 'Récupère toutes les réponses',
                'description' => 'Récupère la liste de toutes les réponses',
                'responses' => [
                    '200' => [
                        'description' => 'Réponses récupérées avec succès',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_reponse']],
        ),
        ]
)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_questionnaire'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_reponse', 'get_questionnaire'])]
    private ?string $reponse = null;

    #[ORM\Column(nullable: false)]
    #[Groups(['get_reponse', 'get_questionnaire'])]
    private int $note = 0;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[Groups(['get_reponse'])]
    private ?Question $question = null;

    #[ORM\OneToOne(mappedBy: 'reponse', targetEntity: Commentaire::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['get_reponse', 'get_questionnaire'])]
    private ?Commentaire $commentaire;

    #[ORM\ManyToMany(targetEntity: ResultatQuestionnaire::class, mappedBy: 'reponses')]
    #[Groups(['get_reponse'])]
    private ?Collection $resultatQuestionnaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getResultatQuestionnaire(): ?Collection
    {
        return $this->resultatQuestionnaire;
    }

    public function setResultatQuestionnaire(?Collection $resultatQuestionnaire): void
    {
        $this->resultatQuestionnaire = $resultatQuestionnaire;
    }

    public function addResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if (!$this->resultatQuestionnaire->contains($resultatQuestionnaire)) {
            $this->resultatQuestionnaire[] = $resultatQuestionnaire;
            $resultatQuestionnaire->addReponse($this);
        }

        return $this;
    }

    public function removeResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if ($this->resultatQuestionnaire->contains($resultatQuestionnaire)) {
            $this->resultatQuestionnaire->removeElement($resultatQuestionnaire);
        }

        return $this;
    }

    public function getCommentaire(): ?Commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Commentaire $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
