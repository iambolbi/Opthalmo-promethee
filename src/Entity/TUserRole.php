<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TUserRoleRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Table(name:"t_user_role")]
#[ORM\Entity(repositoryClass: TUserRoleRepository::class)]
class TUserRole
{
    use TraitEntity;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tUserRoles')]
    private ?TLogin $fk_login = null;

    #[ORM\ManyToOne(inversedBy: 'tUserRoles')]
    private ?TRole $fk_role = null;

    public function __construct()
    {
        if($this->date === null) $this->date = new DateTime();
       
    }

    public function toArray() : ?array
    {
        return $this? [
            'id' => $this->id,
            'fk_user' => $this->fk_login? $this->fk_login->toArray():null,
            'fk_role' => $this->fk_role? $this->fk_role->toArray():null
        ]:null;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFkRole(): ?TRole
    {
        return $this->fk_role;
    }

    public function setFkRole(?TRole $fk_role): static
    {
        $this->fk_role = $fk_role;

        return $this;
    }
}
