<?php

namespace App\Entity\Utils;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use DateTimeInterface;


trait TraitEntity
{

    #[ORM\Column(nullable: true)]
    private ?bool $state = true;

    #[ORM\Column(nullable: true)]
    private ?bool $edit = true;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_edit = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_delete = null;


    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(?bool $state): self
    {
        $this->state = $state;

        if ($state === false) {
            $this->date_delete = new \DateTime();
        } else {
            $this->date_delete = null;
        }

        return $this;
    }

    public function getEdit(): ?bool
    {
        return $this->edit;
    }

    public function setEdit(?bool $edit): self
    {
        $this->edit = $edit;
        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }
    public function setDate(?DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDateEdit(): ?DateTimeInterface
    {
        return $this->date_edit;
    }
    public function setDateEdit(?DateTimeInterface $date_edit): self
    {
        $this->date_edit = $date_edit;

        return $this;
    }

    public function getDateDelete(): ?DateTimeInterface
    {
        return $this->date_delete;
    }
    public function setDateDelete(?DateTimeInterface $date_delete): self
    {
        $this->date_delete = $date_delete;

        return $this;
    }

}
