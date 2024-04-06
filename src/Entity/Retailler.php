<?php

namespace App\Entity;

use App\Repository\RetaillerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetaillerRepository::class)]
class Retailler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $gps = null;

    #[ORM\Column]
    private ?int $monthlyCA = null;

    #[ORM\Column(length: 255)]
    private ?string $quarter = null;

    #[ORM\Column(length: 255)]
    private ?string $placeSaid = null;

    #[ORM\Column]
    private ?bool $tafiyaInterest = null;

    #[ORM\Column]
    private ?bool $existSupplier = null;

    #[ORM\Column]
    private ?bool $takeToMarket = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneOne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneTwo = null;

    #[ORM\ManyToOne(inversedBy: 'retaillers')]
    private ?Supplier $supplier = null;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'retailler')]
    private Collection $product;

    #[ORM\ManyToOne(inversedBy: 'retaillers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CensusTaker $censusTaker = null;

    public function __construct()
    {
        $this->product = new ArrayCollection();
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

    public function getGps(): ?string
    {
        return $this->gps;
    }

    public function setGps(string $gps): static
    {
        $this->gps = $gps;

        return $this;
    }

    public function getMonthlyCA(): ?int
    {
        return $this->monthlyCA;
    }

    public function setMonthlyCA(int $monthlyCA): static
    {
        $this->monthlyCA = $monthlyCA;

        return $this;
    }

    public function getQuarter(): ?string
    {
        return $this->quarter;
    }

    public function setQuarter(string $quarter): static
    {
        $this->quarter = $quarter;

        return $this;
    }

    public function getPlaceSaid(): ?string
    {
        return $this->placeSaid;
    }

    public function setPlaceSaid(string $placeSaid): static
    {
        $this->placeSaid = $placeSaid;

        return $this;
    }

    public function isTafiyaInterest(): ?bool
    {
        return $this->tafiyaInterest;
    }

    public function setTafiyaInterest(bool $tafiyaInterest): static
    {
        $this->tafiyaInterest = $tafiyaInterest;

        return $this;
    }

    public function isExistSupplier(): ?bool
    {
        return $this->existSupplier;
    }

    public function setExistSupplier(bool $existSupplier): static
    {
        $this->existSupplier = $existSupplier;

        return $this;
    }

    public function isTakeToMarket(): ?bool
    {
        return $this->takeToMarket;
    }

    public function setTakeToMarket(bool $takeToMarket): static
    {
        $this->takeToMarket = $takeToMarket;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPhoneOne(): ?string
    {
        return $this->phoneOne;
    }

    public function setPhoneOne(string $phoneOne): static
    {
        $this->phoneOne = $phoneOne;

        return $this;
    }

    public function getPhoneTwo(): ?string
    {
        return $this->phoneTwo;
    }

    public function setPhoneTwo(?string $phoneTwo): static
    {
        $this->phoneTwo = $phoneTwo;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
            $product->setRetailler($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getRetailler() === $this) {
                $product->setRetailler(null);
            }
        }

        return $this;
    }

    public function getCensusTaker(): ?CensusTaker
    {
        return $this->censusTaker;
    }

    public function setCensusTaker(?CensusTaker $censusTaker): static
    {
        $this->censusTaker = $censusTaker;

        return $this;
    }
}
