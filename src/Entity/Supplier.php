<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $hisLastness = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $functioning = null;

    #[ORM\Column(length: 255)]
    private ?string $place = null;

    #[ORM\Column]
    private ?int $transportCost = null;

    #[ORM\OneToMany(targetEntity: Retailler::class, mappedBy: 'supplier')]
    private Collection $retaillers;

    public function __construct()
    {
        $this->retaillers = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Retailler>
     */
    public function getRetaillers(): Collection
    {
        return $this->retaillers;
    }

    public function addRetailler(Retailler $retailler): static
    {
        if (!$this->retaillers->contains($retailler)) {
            $this->retaillers->add($retailler);
            $retailler->setSupplier($this);
        }

        return $this;
    }

    public function removeRetailler(Retailler $retailler): static
    {
        if ($this->retaillers->removeElement($retailler)) {
            // set the owning side to null (unless already changed)
            if ($retailler->getSupplier() === $this) {
                $retailler->setSupplier(null);
            }
        }

        return $this;
    }
}
