<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TPrestationRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"t_prestation")]
#[ORM\Entity(repositoryClass: TPrestationRepository::class)]
class TPrestation
{
    use TraitEntity;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $valeur = null;

    #[ORM\OneToMany(targetEntity: TRendezPrestation::class, mappedBy: 'fk_prestation')]
    private Collection $tRendezPrestations;

  
    public function __construct()
    {
        if($this->date === null) $this->date = new DateTime(); 

        $this->tRendezPrestations = new ArrayCollection();
    }

    public function toArray(): array
    {
        return $this?[
            'id'=> $this->id,
            'libelle' => $this->libelle,
            'valeur' => $this->valeur
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

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(?string $valeur): static
    {
        $this->valeur = $valeur;

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
            $tRendezPrestation->setFkPrestation($this);
        }

        return $this;
    }

    public function removeTRendezPrestation(TRendezPrestation $tRendezPrestation): static
    {
        if ($this->tRendezPrestations->removeElement($tRendezPrestation)) {
            // set the owning side to null (unless already changed)
            if ($tRendezPrestation->getFkPrestation() === $this) {
                $tRendezPrestation->setFkPrestation(null);
            }
        }

        return $this;
    }
}
