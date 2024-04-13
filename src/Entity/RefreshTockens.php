<?php

namespace App\Entity;

use App\Repository\RefreshTockensRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RefreshTockensRepository::class)]
class RefreshTockens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $refreshtoken = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $valid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefreshtoken(): ?string
    {
        return $this->refreshtoken;
    }

    public function setRefreshtoken(string $refreshtoken): static
    {
        $this->refreshtoken = $refreshtoken;

        return $this;
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

    public function getValid(): ?\DateTimeImmutable
    {
        return $this->valid;
    }

    public function setValid(\DateTimeImmutable $valid): static
    {
        $this->valid = $valid;

        return $this;
    }
}
