<?php

namespace App\Entity;

use App\Repository\RetaillerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RetaillerRepository::class)]
class Retailler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getRetailler"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom  est obligatoire")]
    #[Groups(["getRetailler"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de gps est obligatoire")]
    #[Groups(["getRetailler"])]
    private ?string $gps = null;

    #[ORM\Column]
    #[Groups(["getRetailler"])]
    #[Assert\NotBlank(message: "Le nom de Choffre d'affaire est obligatoire")]
    private ?int $monthlyCA = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du quartier est obligatoire")]
    #[Groups(["getRetailler"])]
    private ?string $quarter = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le lieu est obligatoire")]
    #[Groups(["getRetailler"])]
    private ?string $placeSaid = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le est interesse est obligatoire")]
    #[Groups(["getRetailler"])]
    private ?bool $tafiyaInterest = null;

    #[ORM\Column]
    #[Groups(["getRetailler"])]
    private ?bool $existSupplier = null;

    #[ORM\Column]
    #[Groups(["getRetailler"])]
    private ?bool $takeToMarket = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getRetailler"])]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getRetailler"])]
    #[Assert\NotBlank(message: "Le nom numero de telephone 1 est obligatoire")]
    private ?string $phoneOne = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getRetailler"])]
    private ?string $phoneTwo = null;
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le nom  de la ville est obligatoire")]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    #[Groups(["getRetailler"])]
    private ?User $user = null;
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'retailler')]
    private Collection $product;

    

    /**
     * @var Collection<int, Supplier>
     */
    #[ORM\OneToMany(targetEntity: Supplier::class, mappedBy: 'retailler')]
    #[Groups(["getRetailler"])]
    private Collection $supplier;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->supplier = new ArrayCollection();
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


    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $Ville): static
    {
        $this->ville = $Ville;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Supplier>
     */
    public function getSupplier(): Collection
    {
        return $this->supplier;
    }

    public function addSupplier(Supplier $supplier): static
    {
        if (!$this->supplier->contains($supplier)) {
            $this->supplier->add($supplier);
            $supplier->setRetailler($this);
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): static
    {
        if ($this->supplier->removeElement($supplier)) {
            // set the owning side to null (unless already changed)
            if ($supplier->getRetailler() === $this) {
                $supplier->setRetailler(null);
            }
        }

        return $this;
    }
}
