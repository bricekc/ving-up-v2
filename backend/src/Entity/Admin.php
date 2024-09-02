<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
// TODO : modification des opérations pour les admins
#[ApiResource(
    operations: [
        new put(
            normalizationContext: ['groups' => ['get_user']],
            denormalizationContext: ['groups' => ['modif_user']],
            security: "is_granted('ROLE_ADMIN') and object == user"
        ),
        new patch(
            normalizationContext: ['groups' => ['get_user']],
            denormalizationContext: ['groups' => ['modif_user']],
            security: "is_granted('ROLE_ADMIN') and object == user"
        ),
    ]
)]
class Admin extends User
{
    #[ORM\ManyToMany(targetEntity: Rubrique::class, inversedBy: 'admins')]
    private Collection $rubrique;

    public function __construct()
    {
        parent::__construct();
        $this->rubrique = new ArrayCollection();
    }

    /*
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    */

    /**
     * @return Collection<int, Rubrique>
     */
    public function getRubrique(): Collection
    {
        return $this->rubrique;
    }

    public function addRubrique(Rubrique $rubrique): self
    {
        if (!$this->rubrique->contains($rubrique)) {
            $this->rubrique->add($rubrique);
        }

        return $this;
    }

    public function removeRubrique(Rubrique $rubrique): self
    {
        $this->rubrique->removeElement($rubrique);

        return $this;
    }
}
