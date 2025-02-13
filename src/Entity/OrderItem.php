<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    private ?Product $product = null;

    #[ORM\Column(type: 'integer')]
    private ?int $amount = null;

    #[ORM\Column(type: 'float')]
    private ?float $unityPrice = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'items')]
    private ?Order $quote = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getUnityPrice(): ?float
    {
        return $this->unityPrice;
    }

    public function setUnityPrice(float $unityPrice): self
    {
        $this->unityPrice = $unityPrice;

        return $this;
    }

    public function getQuote(): ?Order
    {
        return $this->quote;
    }

    public function setQuote(?Order $quote): self
    {
        $this->quote = $quote;

        return $this;
    }
}
