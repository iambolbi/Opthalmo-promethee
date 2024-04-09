<?php

namespace App\Entity;

use App\Repository\TRendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"t_rendez_vous")]
#[ORM\Entity(repositoryClass: TRendezVousRepository::class)]
class TRendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $diagnostic = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $soin = null;

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
}
