<?php

namespace App\Entity;

use App\Repository\GaleryOfUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GaleryOfUserRepository::class)]
class GaleryOfUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'galeryOfUsers')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'galeryiesUser')]
    private ?NFT $nFT = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

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
