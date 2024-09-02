<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            openapiContext : [
                'summary' => 'Récupère une question par ID',
                'description' => 'Récupère une question par ID',
                'responses' => [
                    '200' => [
                        'description' => 'Question récupérée avec succès',
                    ],
                    '404' => [
                        'description' => 'Question introuvable',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_question']],
        ),
        new getCollection(
            openapiContext : [
                'summary' => 'Récupère toutes les questions',
                'description' => 'Récupère la liste de toutes les questions',
                'responses' => [
                    '200' => [
                        'description' => 'Questions récupérées avec succès',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_question']],
        ),
])]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_question', 'get_questionnaire'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_question', 'get_questionnaire'])]
    private ?string $intitule_question = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[Groups(['get_question'])]
    private ?Questionnaire $questionnaire = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Reponse::class)]
    #[Groups(['get_question', 'get_questionnaire'])]
    private Collection $reponses;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['get_question'])]
    private ?Thematique $thematique = null;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleQuestion(): ?string
    {
        return $this->intitule_question;
    }

    public function setIntituleQuestion(string $intitule_question): self
    {
        $this->intitule_question = $intitule_question;

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

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->intitule_question;
    }

    public function getThematique(): Thematique
    {
        return $this->thematique;
    }

    public function setThematique(?Thematique $thematique): void
    {
        $this->thematique = $thematique;
    }
}
