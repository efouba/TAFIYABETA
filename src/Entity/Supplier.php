<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getSupplier"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getSupplier"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getSupplier"])]
    private ?string $hisLastness = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["getSupplier"])]
    private ?string $functioning = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getSupplier"])]
    private ?string $place = null;

    #[ORM\Column]
    #[Groups(["getSupplier"])]
    private ?int $transportCost = null;

    #[ORM\ManyToOne(inversedBy: 'supplier')]
    #[Groups(["getSupplier"])]
    private ?Retailler $retailler = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getHisLastness(): ?string
    {
        return $this->hisLastness;
    }

    public function setHisLastness(string $hisLastness): static
    {
        $this->hisLastness = $hisLastness;

        return $this;
    }

    public function getFunctioning(): ?string
    {
        return $this->functioning;
    }

    public function setFunctioning(string $functioning): static
    {
        $this->functioning = $functioning;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getTransportCost(): ?int
    {
        return $this->transportCost;
    }

    public function setTransportCost(int $transportCost): static
    {
        $this->transportCost = $transportCost;

        return $this;
    }

    public function getRetailler(): ?Retailler
    {
        return $this->retailler;
    }

    public function setRetailler(?Retailler $retailler): static
    {
        $this->retailler = $retailler;

        return $this;
    }
   
}
