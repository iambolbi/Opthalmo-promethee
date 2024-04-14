<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TRendezPrestationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"t_rendez_prestation")]
#[ORM\Entity(repositoryClass: TRendezPrestationRepository::class)]
class TRendezPrestation
{
    use TraitEntity;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tRendezPrestations')]
    private ?TPrestation $fk_prestation = null;

    #[ORM\ManyToOne(inversedBy: 'tRendezPrestations')]
    private ?TAssurance $fk_assurance = null;

    #[ORM\ManyToOne(inversedBy: 'tRendezPrestations')]
    private ?TRendezVous $fk_rendez_vous = null;

    #[ORM\ManyToOne(inversedBy: 'tRendezPrestations')]
    private ?TMedecin $fk_medecin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $part_patient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $part_assurance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkPrestation(): ?TPrestation
    {
        return $this->fk_prestation;
    }

    public function setFkPrestation(?TPrestation $fk_prestation): static
    {
        $this->fk_prestation = $fk_prestation;

        return $this;
    }

    public function getFkAssurance(): ?TAssurance
    {
        return $this->fk_assurance;
    }

    public function setFkAssurance(?TAssurance $fk_assurance): static
    {
        $this->fk_assurance = $fk_assurance;

        return $this;
    }

    public function getFkRendezVous(): ?TRendezVous
    {
        return $this->fk_rendez_vous;
    }

    public function setFkRendezVous(?TRendezVous $fk_rendez_vous): static
    {
        $this->fk_rendez_vous = $fk_rendez_vous;

        return $this;
    }

    public function getFkMedecin(): ?TMedecin
    {
        return $this->fk_medecin;
    }

    public function setFkMedecin(?TMedecin $fk_medecin): static
    {
        $this->fk_medecin = $fk_medecin;

        return $this;
    }

    public function getPartPatient(): ?string
    {
        return $this->part_patient;
    }

    public function setPartPatient(?string $part_patient): static
    {
        $this->part_patient = $part_patient;

        return $this;
    }

    public function getPartAssurance(): ?string
    {
        return $this->part_assurance;
    }

    public function setPartAssurance(?string $part_assurance): static
    {
        $this->part_assurance = $part_assurance;

        return $this;
    }
}
