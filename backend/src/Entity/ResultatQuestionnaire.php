<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ResultatQuestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ResultatQuestionnaireRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            openapiContext : [
                'summary' => 'Récupère un ResultatQuestionnaire par ID',
                'description' => 'Récupère une ResultatQuestionnaire par ID',
                'responses' => [
                    '200' => [
                        'description' => 'ResultatQuestionnaire récupérée avec succès',
                    ],
                    '404' => [
                        'description' => 'ResultatQuestionnaire introuvable',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_resultat']],
        ),
        new GetCollection(
            routeName: 'get_user_resultat',
            openapiContext: [
                'summary' => 'Récupère les ResultatQuestionnaire d\'un utilisateur',
                'description' => 'Récupère les ResultatQuestionnaire d\'un utilisateur par ID utilisateur',
                'parameters' => [
                    [
                        'name' => 'userId',
                        'in' => 'path',
                        'required' => true,
                        'schema' => ['type' => 'integer'],
                    ],
                ],
                'responses' => [
                    '200' => [
                        'description' => 'ResultatQuestionnaires récupérés avec succès',
                    ],
                    '404' => [
                        'description' => 'Aucun ResultatQuestionnaire trouvé',
                    ],
                ],
            ],
            paginationEnabled: false,
            normalizationContext: ['groups' => ['get_resultat']],
        ),
        new GetCollection(
            openapiContext : [
                'summary' => 'Récupère tous les ResultatQuestionnaire',
                'description' => 'Récupère la liste de tous les ResultatQuestionnaires',
                'responses' => [
                    '200' => [
                        'description' => 'ResultatQuestionnaire récupérées avec succès',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_resultat']],
        ),
        new Post(
            openapiContext : [
                'summary' => 'Crée un nouveau ResultatQuestionnaire',
                'description' => 'Crée un nouveau ResultatQuestionnaire avec les informations fournies',
                'responses' => [
                    '201' => [
                        'description' => 'ResultatQuestionnaire créé avec succès',
                    ],
                    '400' => [
                        'description' => 'Requête invalide',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_resultat']],
            denormalizationContext : ['groups' => ['post_resultat']]
        ),
        new Put(
            openapiContext : [
                'summary' => 'Met à jour un ResultatQuestionnaire',
                'description' => 'Met à jour un ResultatQuestionnaire existant avec les informations fournies',
                'responses' => [
                    '200' => [
                        'description' => 'ResultatQuestionnaire mis à jour avec succès',
                    ],
                    '400' => [
                        'description' => 'Requête invalide',
                    ],
                    '404' => [
                        'description' => 'ResultatQuestionnaire introuvable',
                    ],
                ],
            ],
            normalizationContext : ['groups' => ['get_resultat']],
            denormalizationContext : ['groups' => ['put_resultat']]
        ),
    ]
)]
class ResultatQuestionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_resultat'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['get_resultat', 'put_resultat', 'post_resultat'])]
    private ?int $note = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['get_resultat'])]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(targetEntity: Questionnaire::class, inversedBy: 'resultatQuestionnaires')]
    #[Groups(['get_resultat', 'put_resultat', 'post_resultat'])]
    private ?Questionnaire $questionnaire = null;

    #[ORM\ManyToOne(targetEntity: Viticulteur::class, inversedBy: 'resultatQuestionnaires')]
    #[Groups(['get_resultat', 'put_resultat', 'post_resultat'])]
    private ?Viticulteur $viticulteur = null;

    #[ORM\ManyToMany(targetEntity: Reponse::class, inversedBy: 'resultatQuestionnaire', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'resultat_questionnaire_id', referencedColumnName: 'id')]
    #[Groups(['get_resultat', 'put_resultat', 'post_resultat'])]
    private Collection|array|null $reponses;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
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

    public function getViticulteur(): ?Viticulteur
    {
        return $this->viticulteur;
    }

    public function setViticulteur(?Viticulteur $viticulteur): self
    {
        $this->viticulteur = $viticulteur;

        return $this;
    }

    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function setReponses(Collection|array|null $reponses): self
    {
        $this->reponses = $reponses;

        return $this;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->addResultatQuestionnaire($this);
        }

        return $this;
    }
}
