<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $operationAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isABuy = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    private ?NFT $nFT = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationAt(): ?\DateTimeInterface
    {
        return $this->operationAt;
    }

    public function setOperationAt(?\DateTimeInterface $operationAt): static
    {
        $this->operationAt = $operationAt;

        return $this;
    }

    public function isIsABuy(): ?bool
    {
        return $this->isABuy;
    }

    public function setIsABuy(?bool $isABuy): static
    {
        $this->isABuy = $isABuy;

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

    public function getNFT(): ?NFT
    {
        return $this->nFT;
    }

    public function setNFT(?NFT $nFT): static
    {
        $this->nFT = $nFT;

        return $this;
    }
}
