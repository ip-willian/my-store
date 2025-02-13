<?php

namespace App\Entity;

use App\Descriptor\OrderStatusDescriptor;
use App\Repository\LoggerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoggerRepository::class)]
class Logger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'string', length: 1)]
    private string $orderStatus;

    #[ORM\Column(type: 'text')]
    private string $message;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'history')]
    private ?Order $orderToLog;

    public function __construct(Order $order)
    {
        $this->createdAt = new \DateTime();
        $this->orderToLog = $order;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOrderStatus(): ?string
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(string $orderStatus): self
    {
        $this->orderStatus = $orderStatus;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getOrderToLog(): ?Order
    {
        return $this->orderToLog;
    }

    public function setOrderToLog(?Order $orderToLog): self
    {
        $this->orderToLog = $orderToLog;
        return $this;
    }

    public function getStatusDescription(): string
    {
        return OrderStatusDescriptor::getDescriptor($this->getOrderStatus());
    }
}
