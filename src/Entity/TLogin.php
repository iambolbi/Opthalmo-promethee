<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TLoginRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: TLoginRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[ORM\Table(name:"t_login")]
class TLogin implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TraitEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: TUserRole::class, mappedBy: 'fk_login')]
    private Collection $tUserRoles;

    #[ORM\OneToMany(targetEntity: TRendezVous::class, mappedBy: 'fk_login')]
    private Collection $tRendezVous;

    #[ORM\OneToMany(targetEntity: TLog::class, mappedBy: 'fk_login')]
    private Collection $tLogs;

    public function __construct()
    {
        if($this->date === null) $this->date = new DateTime();

        $this->tUserRoles = new ArrayCollection();
        $this->tRendezVous = new ArrayCollection();
        $this->tLogs = new ArrayCollection();
    }


    public function toArray(): ?array
    {
        return $this? [
            'id'=> $this->id,
            'username' => $this->username,
            'tUserRoles' => $this->getTUserRoles()->toArray()
            // 'tUserRoles' =>  array_map(function (TUserRole $userRole) {
            //     return $userRole->toArray();
            // }, array_filter($this->getTUserRoles()->getValues(), function (TUserRole $userRole) {
            //     return $userRole->getState() === true && $userRole->getFkRole() && $userRole->getFkRole()->getState() === true;
            // })), 
        ]:null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

   
    public function getRoles(): array
    {
        $roles = $this->roles;
       // $userRoles = $this->tUserRoles->getValues();
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_ADMIN';
        // foreach($userRoles as $role)
        // {
        //     if($role->getState() && $role->getFkLogin() && $role->getFkLogin()->getState()){
        //         $roles = array_merge($roles, $role->getFkLogin()->getRoles());
        //     }
        // }

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $tUserRole->setFkLogin($this);
        }

        return $this;
    }

    public function removeTUserRole(TUserRole $tUserRole): static
    {
        if ($this->tUserRoles->removeElement($tUserRole)) {
            // set the owning side to null (unless already changed)
            if ($tUserRole->getFkLogin() === $this) {
                $tUserRole->setFkLogin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TRendezVous>
     */
    public function getTRendezVous(): Collection
    {
        return $this->tRendezVous;
    }

    public function addTRendezVous(TRendezVous $tRendezVous): static
    {
        if (!$this->tRendezVous->contains($tRendezVous)) {
            $this->tRendezVous->add($tRendezVous);
            $tRendezVous->setFkLogin($this);
        }

        return $this;
    }

    public function removeTRendezVouse(TRendezVous $tRendezVous): static
    {
        if ($this->tRendezVous->removeElement($tRendezVous)) {
            // set the owning side to null (unless already changed)
            if ($tRendezVous->getFkLogin() === $this) {
                $tRendezVous->setFkLogin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TLog>
     */
    public function getTLogs(): Collection
    {
        return $this->tLogs;
    }

    public function addTLog(TLog $tLog): static
    {
        if (!$this->tLogs->contains($tLog)) {
            $this->tLogs->add($tLog);
            $tLog->setFkLogin($this);
        }

        return $this;
    }

    public function removeTLog(TLog $tLog): static
    {
        if ($this->tLogs->removeElement($tLog)) {
            // set the owning side to null (unless already changed)
            if ($tLog->getFkLogin() === $this) {
                $tLog->setFkLogin(null);
            }
        }

        return $this;
    }
}
