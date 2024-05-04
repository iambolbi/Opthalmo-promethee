<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TRendezVousRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

#[ORM\Table(name:"t_rendez_vous")]
#[ORM\Entity(repositoryClass: TRendezVousRepository::class)]
class TRendezVous
{
    use TraitEntity;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $diagnostic = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $soin = null;

    #[ORM\ManyToOne(inversedBy: 'tRendezVous')]
    private ?TLogin $fk_login = null;

    #[ORM\ManyToOne(inversedBy: 'tRendezVous')]
    private ?TPatient $fk_patient = null;

    #[ORM\OneToMany(targetEntity: TRendezPrestation::class, mappedBy: 'fk_rendez_vous')]
    private Collection $tRendezPrestations;

    #[ORM\Column(nullable: true)]
    private ?bool $statut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $date_rendez_vous = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

   
    public function __construct()
    {
        if($this->date === null) $this->date = new DateTime(); 

        $this->tRendezPrestations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiagnostic(): ?string
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(?string $diagnostic): static
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    public function getSoin(): ?string
    {
        return $this->soin;
    }

    public function setSoin(?string $soin): static
    {
        $this->soin = $soin;

        return $this;
    }

    public function getFkLogin(): ?TLogin
    {
        return $this->fk_login;
    }

    public function setFkLogin(?TLogin $fk_login): static
    {
        $this->fk_login = $fk_login;

        return $this;
    }

    public function getFkPatient(): ?TPatient
    {
        return $this->fk_patient;
    }

    public function setFkPatient(?TPatient $fk_patient): static
    {
        $this->fk_patient = $fk_patient;

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
            $tRendezPrestation->setFkRendezVous($this);
        }

        return $this;
    }

    public function removeTRendezPrestation(TRendezPrestation $tRendezPrestation): static
    {
        if ($this->tRendezPrestations->removeElement($tRendezPrestation)) {
            // set the owning side to null (unless already changed)
            if ($tRendezPrestation->getFkRendezVous() === $this) {
                $tRendezPrestation->setFkRendezVous(null);
            }
        }

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateRendezVous(): ?\DateTimeInterface
    {
        return $this->date_rendez_vous;
    }

    public function setDateRendezVous(?\DateTimeInterface $date_rendez_vous): static
    {
        $this->date_rendez_vous = $date_rendez_vous;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }
}
