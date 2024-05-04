<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TPatientRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"t_patient")]
#[ORM\Entity(repositoryClass: TPatientRepository::class)]
class TPatient
{
    use TraitEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\OneToMany(targetEntity: TRendezVous::class, mappedBy: 'fk_patient')]
    private Collection $tRendezVouses;

    public function toArray(): array
    {
        return $this?[
            'id'=>$this->id,
            'nom'=>$this->nom,
            'prenom'=>$this->prenom,
            'contact'=>$this->contact,
            'adresse'=>$this->adresse,
        ]:null;
    }

  
    public function __construct()
    {
        if($this->date === null) $this->date = new DateTime(); 
        $this->tRendezVouses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
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
     * @return Collection<int, TRendezVous>
     */
    public function getTRendezVouses(): Collection
    {
        return $this->tRendezVouses;
    }

    public function addTRendezVouse(TRendezVous $tRendezVouse): static
    {
        if (!$this->tRendezVouses->contains($tRendezVouse)) {
            $this->tRendezVouses->add($tRendezVouse);
            $tRendezVouse->setFkPatient($this);
        }

        return $this;
    }

    public function removeTRendezVouse(TRendezVous $tRendezVouse): static
    {
        if ($this->tRendezVouses->removeElement($tRendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($tRendezVouse->getFkPatient() === $this) {
                $tRendezVouse->setFkPatient(null);
            }
        }

        return $this;
    }
}
