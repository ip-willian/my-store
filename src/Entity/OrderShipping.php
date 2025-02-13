<?php

namespace App\Entity;

use App\Repository\OrderShippingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderShippingRepository::class)]
class OrderShipping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 150)]
    private ?string $company = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $trackingNumber = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $shippingLabel = null;

    private mixed $shippingLabelFile = null;

    #[ORM\OneToOne(targetEntity: Order::class, inversedBy: 'shipping', cascade: ['persist', 'remove'])]
    private ?Order $orderToShip = null;

    public function __construct(Order $orderToShip)
    {
        $this->orderToShip = $orderToShip;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(string $trackingNumber): self
    {
        $this->trackingNumber = $trackingNumber;

        return $this;
    }

    public function getShippingLabel(): ?string
    {
        return $this->shippingLabel;
    }

    public function setShippingLabel(string $shippingLabel): self
    {
        $this->shippingLabel = $shippingLabel;

        return $this;
    }

    public function getOrderToShip(): ?Order
    {
        return $this->orderToShip;
    }

    public function setOrderToShip(?Order $orderToShip): self
    {
        $this->orderToShip = $orderToShip;

        return $this;
    }

    public function getShippingLabelFile(): mixed
    {
        return $this->shippingLabelFile;
    }

    public function setShippingLabelFile(mixed $shippingLabelFile): void
    {
        $this->shippingLabelFile = $shippingLabelFile;
    }
}
