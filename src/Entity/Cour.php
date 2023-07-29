<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CourRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CourRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'cour:list'
            ]
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'cour:items'
            ]
        ],
    ],
)]
class Cour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['cour:list', 'cour:items','nft:items', 'nft:list'])]
    private ?float $value = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['cour:list', 'cour:items', 'nft:items', 'nft:list'])]
    private ?\DateTimeInterface $dateCour = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[Groups(['cour:list', 'cour:items'])]
    private ?NFT $nft = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getDateCour(): ?\DateTimeInterface
    {
        return $this->dateCour;
    }

    public function setDateCour(?\DateTimeInterface $dateCour): static
    {
        $this->dateCour = $dateCour;

        return $this;
    }

    public function getNft(): ?NFT
    {
        return $this->nft;
    }

    public function setNft(?NFT $nft): static
    {
        $this->nft = $nft;

        return $this;
    }
}
