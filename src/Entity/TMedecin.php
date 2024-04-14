<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TMedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"t_medecin")]
#[ORM\Entity(repositoryClass: TMedecinRepository::class)]
class TMedecin
{

    use TraitEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\OneToMany(targetEntity: TRendezPrestation::class, mappedBy: 'fk_medecin')]
    private Collection $tRendezPrestations;

    public function __construct()
    {
        
        $this->tRendezPrestations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

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
            $tRendezPrestation->setFkMedecin($this);
        }

        return $this;
    }

    public function removeTRendezPrestation(TRendezPrestation $tRendezPrestation): static
    {
        if ($this->tRendezPrestations->removeElement($tRendezPrestation)) {
            // set the owning side to null (unless already changed)
            if ($tRendezPrestation->getFkMedecin() === $this) {
                $tRendezPrestation->setFkMedecin(null);
            }
        }

        return $this;
    }
}
