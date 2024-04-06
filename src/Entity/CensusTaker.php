<?php

namespace App\Entity;

use App\Repository\CensusTakerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CensusTakerRepository::class)]
class CensusTaker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: Retailler::class, mappedBy: 'censusTaker')]
    private Collection $retaillers;

    public function __construct()
    {
        $this->retaillers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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
            $retailler->setCensusTaker($this);
        }

        return $this;
    }

    public function removeRetailler(Retailler $retailler): static
    {
        if ($this->retaillers->removeElement($retailler)) {
            // set the owning side to null (unless already changed)
            if ($retailler->getCensusTaker() === $this) {
                $retailler->setCensusTaker(null);
            }
        }

        return $this;
    }
}
