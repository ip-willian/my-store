<?php

namespace App\Entity;

use App\Descriptor\OrderIssuesDescriptor;
use App\Repository\IssueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IssueRepository::class)]
class Issue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 1)]
    private string $cause;

    #[ORM\Column(type: "text")]
    private string $message;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "issues")]
    private ?Order $orderIssue = null;

    #[ORM\Column(type: "boolean")]
    private bool $isFixed = false;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;

    public function __construct($orderIssue)
    {
        $this->orderIssue = $orderIssue;
        $this->isFixed = false;
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCause(): ?string
    {
        return $this->cause;
    }

    public function getCauseDescription()
    {
        return OrderIssuesDescriptor::getDescriptor($this->cause);
    }

    public function setCause(string $cause): self
    {
        $this->cause = $cause;
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

    public function getOrderIssue(): ?Order
    {
        return $this->orderIssue;
    }

    public function setOrderIssue(?Order $orderIssue): self
    {
        $this->orderIssue = $orderIssue;
        return $this;
    }

    public function getIsFixed(): ?bool
    {
        return $this->isFixed;
    }

    public function setIsFixed(bool $isFixed): self
    {
        $this->isFixed = $isFixed;
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