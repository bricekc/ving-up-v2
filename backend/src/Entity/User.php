<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Controller\GetAvatarController;
use App\Controller\GetMeController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'discriminator', type: 'string')]
#[DiscriminatorMap(['viticulteur' => Viticulteur::class, 'fournisseur' => Fournisseur::class, 'admin' => Admin::class])]
#[ApiResource(
    operations: [
        new get(
            normalizationContext: ['groups' => ['get_user']]
        ),
        new getCollection(
            normalizationContext: ['groups' => ['get_user']]
        ),
        new GetCollection(
            uriTemplate: '/me',
            controller: GetMeController::class,
            openapiContext: [
                'description' => "Retourne l'utilisateur connecté",
                'responses' => [
                    '200' => [
                        'description' => "Retourne l'utilisateur connecté",
                    ],
                    '401' => [
                        'description' => "L'utilisateur n'es pas connecté et n'a pas accès à cette opération",
                    ],
                ],
            ],
            paginationEnabled: false,
            normalizationContext: ['groups' => ['get_user']],

            security: "is_granted('ROLE_USER')",
        ),
        new Get(
            uriTemplate: '/users/{id}/avatar',
            formats: [
                'png' => 'image/png',
            ],

            controller: GetAvatarController::class,

            openapiContext: [
                'content' => [
                    'image/png' => [
                        'schema' => [
                            'type' => 'string',
                            'format' => 'binary',
                        ],
                    ],
                ],
            ]
        ),
        new put(
            normalizationContext: ['groups' => ['get_user']],
            denormalizationContext: ['groups' => ['modif_user']],
            security: 'object == user'
        ),
        new patch(
            normalizationContext: ['groups' => ['get_user']],
            denormalizationContext: ['groups' => ['modif_user']],
            security: 'object == user'
        ),
        new delete(
            security: "is_granted('ROLE_ADMIN') or object == user"
        ),
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity(['fields' => 'email']));
        $metadata->addPropertyConstraint('email', new Assert\Email());
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_user', 'get_Sujet', 'get_Post'])]
    protected ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['get_user', 'modif_user'])]
    protected ?string $email = null;

    #[ORM\Column]
    protected array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['modif_user'])]
    protected ?string $password = null;

    #[ORM\Column(length: 35)]
    #[Groups(['get_user', 'modif_user', 'get_Sujet', 'get_Post'])]
    protected ?string $lastname = null;

    #[ORM\Column(length: 35)]
    #[Groups(['get_user', 'modif_user', 'get_Sujet', 'get_Post'])]
    protected ?string $firstname = null;

    #[ORM\Column(length: 35, nullable: true)]
    #[Groups(['get_user', 'modif_user'])]
    protected ?string $ville = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Groups(['get_user', 'modif_user'])]
    protected ?string $cp = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['get_user', 'modif_user'])]
    protected ?string $adresse = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    protected $photo_profil = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Post::class)]
    protected Collection $posts;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    #[Groups(['get_user'])]
    protected \DateTimeInterface $dateCreation;

    #[ORM\Column]
    #[Groups(['get_user'])]
    private int $nbPost = 0;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->dateCreation = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Get role according to real User class.
     * Examples:
     *  - App\Entity\Viticulteur -> ROLE_VITICULTEUR
     *  - App\Entity\Fournisseur -> ROLE_FOURNISSEUR.
     */
    protected function getRole(): string
    {
        $explodedClassname = explode('\\', static::class);
        $className = mb_strtoupper(array_pop($explodedClassname));

        return "ROLE_$className";
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        // add role according to real User class
        $roles[] = $this->getRole();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPhotoProfil()
    {
        return $this->photo_profil;
    }

    public function setPhotoProfil($photo_profil): self
    {
        $this->photo_profil = $photo_profil;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getNbPost(): ?int
    {
        return $this->nbPost;
    }

    public function setNbPost(int $nbPost): self
    {
        $this->nbPost = $nbPost;

        return $this;
    }
}
