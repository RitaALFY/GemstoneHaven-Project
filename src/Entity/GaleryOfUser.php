<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\GaleryOfUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GaleryOfUserRepository::class)]
#[ApiResource
(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'galeryofuser:list'
            ]
        ],
        'post' => [
            'denormalization_context' => [
                'groups' => 'galeryofuser:post'
            ]
        ],



    ],
    itemOperations: [
       'get' => [
           'normalization_context' => [
               'groups' => 'galeryofuser:items'
           ]
       ],
        'put',
    ],
)]


#[ApiFilter(
    DateFilter::class, properties: [
    'createdAt'
]
)]
class GaleryOfUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['galeryofuser:post', 'galeryofuser:list','nft:items','galeryofuser:items', 'user:items'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'galeryOfUsers')]
    #[Groups(['galeryofuser:post','user:items', 'galeryofuser:list','galeryofuser:items', 'nft:items'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'galeryiesUser')]
    #[Groups(['galeryofuser:post', 'galeryofuser:list', 'user:items', 'nft:items','galeryofuser:items'])]
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
