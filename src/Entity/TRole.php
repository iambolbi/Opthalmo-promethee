<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"t_role")]
#[ORM\Entity(repositoryClass: TRoleRepository::class)]
class TRole
{
    use TraitEntity;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    private ?array $roles = null;

    #[ORM\OneToMany(targetEntity: TUserRole::class, mappedBy: 'fk_role')]
    private Collection $tUserRoles;

    public function __construct()
    {
        $this->tUserRoles = new ArrayCollection();
    }

    public function toArray():array
    {
        return $this?[
            'id'=> $this->id,
            'libelle' => $this->libelle,
            'roles' => $this->roles,
        ]:[];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, TUserRole>
     */
    public function getTUserRoles(): Collection
    {
        return $this->tUserRoles;
    }

    public function addTUserRole(TUserRole $tUserRole): static
    {
        if (!$this->tUserRoles->contains($tUserRole)) {
            $this->tUserRoles->add($tUserRole);
            $tUserRole->setFkRole($this);
        }

        return $this;
    }

    public function removeTUserRole(TUserRole $tUserRole): static
    {
        if ($this->tUserRoles->removeElement($tUserRole)) {
            // set the owning side to null (unless already changed)
            if ($tUserRole->getFkRole() === $this) {
                $tUserRole->setFkRole(null);
            }
        }

        return $this;
    }
}
