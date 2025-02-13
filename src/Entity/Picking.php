<?php

namespace App\Entity;

use App\Descriptor\PickingStatusDescriptor;
use App\Repository\PickingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PickingRepository::class)]
class Picking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Order::class, inversedBy: 'picking', cascade: ['persist', 'remove'])]
    private ?Order $orderPicked = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $owner = null;

    #[ORM\Column(type: 'string', length: 1)]
    private string $status;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function __construct(Order $orderPicked, User $owner)
    {
        $this->orderPicked = $orderPicked;
        $this->owner = $owner;
        $this->createdAt = new \DateTime();
        $this->status = PickingStatusDescriptor::OPEN;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderPicked(): ?Order
    {
        return $this->orderPicked;
    }

    public function setOrderPicked(?Order $orderPicked): self
    {
        $this->orderPicked = $orderPicked;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getStatusDescription()
    {
        return PickingStatusDescriptor::getDescriptor($this->getStatus());
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
}
