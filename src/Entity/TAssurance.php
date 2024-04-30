<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TAssuranceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"t_assurance")]
#[ORM\Entity(repositoryClass: TAssuranceRepository::class)]
class TAssurance
{
    use TraitEntity;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\OneToMany(targetEntity: TRendezPrestation::class, mappedBy: 'fk_assurance')]
    private Collection $tRendezPrestations;

    public function __construct()
    {
        $this->tRendezPrestations = new ArrayCollection();
    }


    public function toArray(): array
    {
        return $this?[
            'id'=> $this->id,
            'libelle' => $this->libelle
        ]:null;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, TRendezPrestation>
     */
    public function getTRendezPrestations(): Collection
    {
        return $this->tRendezPrestations;
    }

    public function addTRendezPrestation(TRendezPrestation $tRendezPrestation): static
    {
        if (!$this->tRendezPrestations->contains($tRendezPrestation)) {
            $this->tRendezPrestations->add($tRendezPrestation);
            $tRendezPrestation->setFkAssurance($this);
        }

        return $this;
    }

    public function removeTRendezPrestation(TRendezPrestation $tRendezPrestation): static
    {
        if ($this->tRendezPrestations->removeElement($tRendezPrestation)) {
            // set the owning side to null (unless already changed)
            if ($tRendezPrestation->getFkAssurance() === $this) {
                $tRendezPrestation->setFkAssurance(null);
            }
        }

        return $this;
    }
}
