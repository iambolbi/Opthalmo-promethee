<?php

namespace App\Entity;

use App\Entity\Utils\TraitEntity;
use App\Repository\TLogRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"t_log")]
#[ORM\Entity(repositoryClass: TLogRepository::class)]
class TLog
{
    use TraitEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $uri = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $method = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status_code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $action = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'tLogs')]
    private ?TLogin $fk_login = null;

    public function __construct()
    {
        if($this->date === null) $this->date = new DateTime(); 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(?string $uri): static
    {
        $this->uri = $uri;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(?string $method): static
    {
        $this->method = $method;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getStatusCode(): ?string
    {
        return $this->status_code;
    }

    public function setStatusCode(?string $status_code): static
    {
        $this->status_code = $status_code;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

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
}
