<?php

namespace App\Entity;

use App\Descriptor\OrderStatusDescriptor;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 1)]
    private string $status;

    #[ORM\Column(type: 'float')]
    private float $total;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'quote', cascade: ['persist', 'remove'])]
    private Collection $items;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'float')]
    private float $discount;

    #[ORM\Column(type: 'string', length: 255)]
    private string $address;

    #[ORM\Column(type: 'string', length: 20)]
    private string $addressNumber;

    #[ORM\Column(type: 'string', length: 20)]
    private string $postalCode;

    #[ORM\Column(type: 'string', length: 100)]
    private string $city;

    #[ORM\OneToOne(targetEntity: OrderShipping::class, mappedBy: 'orderToShip')]
    private ?OrderShipping $shipping = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $boxId = null;

    #[ORM\OneToMany(targetEntity: Issue::class, mappedBy: 'orderIssue')]
    private Collection $issues;

    #[ORM\OneToOne(targetEntity: Picking::class, mappedBy: 'orderPicked', cascade: ['persist', 'remove'])]
    private ?Picking $picking = null;

    #[ORM\Column(type: 'boolean')]
    private bool $hasIssue;

    #[ORM\OneToMany(targetEntity: Logger::class, mappedBy: 'orderToLog')]
    private Collection $history;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->issues = new ArrayCollection();
        $this->history = new ArrayCollection();
        $this->status = OrderStatusDescriptor::ORDER_RECEIVED;
        $this->createdAt = new \DateTime();
        $this->hasIssue = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatusDescription(): string
    {
        return OrderStatusDescriptor::getDescriptor($this->status);
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getAddressNumber(): string
    {
        return $this->addressNumber;
    }

    public function setAddressNumber(string $addressNumber): self
    {
        $this->addressNumber = $addressNumber;
        return $this;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getHasIssue(): bool
    {
        return $this->hasIssue;
    }

    public function setHasIssue(bool $hasIssue): self
    {
        $this->hasIssue = $hasIssue;
        return $this;
    }

    public function getHistory(): Collection
    {
        return $this->history;
    }

    public function addHistory(Logger $history): self
    {
        if (!$this->history->contains($history)) {
            $this->history[] = $history;
            $history->setOrderToLog($this);
        }

        return $this;
    }

    public function removeHistory(Logger $history): self
    {
        if ($this->history->removeElement($history)) {
            // set the owning side to null (unless already changed)
            if ($history->getOrderToLog() === $this) {
                $history->setOrderToLog(null);
            }
        }

        return $this;
    }
}
