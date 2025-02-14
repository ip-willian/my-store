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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getStatusDescription() {
        return OrderStatusDescriptor::getDescriptor($this->status);
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setQuote($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getQuote() === $this) {
                $item->setQuote(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAddressNumber(): ?string
    {
        return $this->addressNumber;
    }

    public function setAddressNumber(string $addressNumber): self
    {
        $this->addressNumber = $addressNumber;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getShipping(): ?OrderShipping
    {
        return $this->shipping;
    }

    public function setShipping(?OrderShipping $shipping): self
    {
        // unset the owning side of the relation if necessary
        if ($shipping === null && $this->shipping !== null) {
            $this->shipping->setOrderToShip(null);
        }

        // set the owning side of the relation if necessary
        if ($shipping !== null && $shipping->getOrderToShip() !== $this) {
            $shipping->setOrderToShip($this);
        }

        $this->shipping = $shipping;

        return $this;
    }

    public function getBoxId(): ?string
    {
        return $this->boxId;
    }

    public function setBoxId(?string $boxId): self
    {
        $this->boxId = $boxId;

        return $this;
    }

    /**
     * @return Collection|Issue[]
     */
    public function getIssues(): Collection
    {
        return $this->issues;
    }

    public function addIssue(Issue $issue): self
    {
        if (!$this->issues->contains($issue)) {
            $this->issues[] = $issue;
            $issue->setOrderIssue($this);
        }

        return $this;
    }

    public function removeIssue(Issue $issue): self
    {
        if ($this->issues->removeElement($issue)) {
            // set the owning side to null (unless already changed)
            if ($issue->getOrderIssue() === $this) {
                $issue->setOrderIssue(null);
            }
        }

        return $this;
    }

    public function getPicking(): ?Picking
    {
        return $this->picking;
    }

    public function setPicking(?Picking $picking): self
    {
        // unset the owning side of the relation if necessary
        if ($picking === null && $this->picking !== null) {
            $this->picking->setOrderPicked(null);
        }

        // set the owning side of the relation if necessary
        if ($picking !== null && $picking->getOrderPicked() !== $this) {
            $picking->setOrderPicked($this);
        }

        $this->picking = $picking;

        return $this;
    }

    public function getHasIssue(): ?bool
    {
        return $this->hasIssue;
    }

    public function setHasIssue(bool $hasIssue): self
    {
        $this->hasIssue = $hasIssue;

        return $this;
    }

    /**
     * @return Collection|Logger[]
     */
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
