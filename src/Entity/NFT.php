<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\NFTRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NFTRepository::class)]
#[ApiResource
(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'nft:list'
            ]
        ],
        'post' => [
            'denormalization_context' => [
                'groups' => 'nft:post'
            ]
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'nft:items'
            ]
        ],
        'put',
    ],
)]



#[ApiFilter(
    OrderFilter::class,
    properties: [
        'name',
        'currentValue ',
    ],
    arguments: [
        'orderParameterName' => 'order'
    ])
]
class NFT implements SlugInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:post', 'nft:items', 'nft:list', 'cour:list', 'user:items', 'cour:items','galeryofuser:list', 'galeryofuser:items','subcategory:list', 'subcategory:items'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:post', 'nft:items', 'nft:list'])]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['nft:post', 'nft:items', 'nft:list'])]
    private ?\DateTimeInterface $dropAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:post', 'nft:items', 'nft:list'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['nft:post', 'nft:items', 'nft:list'])]
    private ?int $availableQuantity = null;

    #[ORM\Column]
    #[Groups(['nft:post', 'nft:items', 'nft:list'])]
    private ?float $currentValue = null;

    #[ORM\Column(length: 255)]
    #[Groups([ 'nft:items', 'nft:list'])]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'nfts')]
    #[Groups(['nft:post', 'nft:items', 'nft:list'])]
    private ?SubCategory $subCategory = null;

    #[ORM\OneToMany(mappedBy: 'nft', targetEntity: Cour::class)]
    #[Groups(['nft:post', 'nft:items', 'nft:list'])]
    private Collection $cours;

    #[ORM\OneToMany(mappedBy: 'nFT', targetEntity: Operation::class)]
    private Collection $operations;

    #[ORM\OneToMany(mappedBy: 'nFT', targetEntity: Intervention::class)]
    private Collection $interventions;

    #[ORM\OneToMany(mappedBy: 'nFT', targetEntity: GaleryOfUser::class)]
    #[Groups(['nft:post', 'nft:items', 'nft:list'])]
    private Collection $galeryiesUser;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->operations = new ArrayCollection();
        $this->interventions = new ArrayCollection();
        $this->galeryiesUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDropAt(): ?\DateTimeInterface
    {
        return $this->dropAt;
    }

    public function setDropAt(\DateTimeInterface $dropAt): static
    {
        $this->dropAt = $dropAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAvailableQuantity(): ?int
    {
        return $this->availableQuantity;
    }

    public function setAvailableQuantity(int $availableQuantity): static
    {
        $this->availableQuantity = $availableQuantity;

        return $this;
    }

    public function getCurrentValue(): ?float
    {
        return $this->currentValue;
    }

    public function setCurrentValue(float $currentValue): static
    {
        $this->currentValue = $currentValue;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): static
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * @return Collection<int, Cour>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cour $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setNft($this);
        }

        return $this;
    }

    public function removeCour(Cour $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getNft() === $this) {
                $cour->setNft(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): static
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
            $operation->setNFT($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getNFT() === $this) {
                $operation->setNFT(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Intervention>
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): static
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions->add($intervention);
            $intervention->setNFT($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): static
    {
        if ($this->interventions->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getNFT() === $this) {
                $intervention->setNFT(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GaleryOfUser>
     */
    public function getGaleryiesUser(): Collection
    {
        return $this->galeryiesUser;
    }

    public function addGaleryiesUser(GaleryOfUser $galeryiesUser): static
    {
        if (!$this->galeryiesUser->contains($galeryiesUser)) {
            $this->galeryiesUser->add($galeryiesUser);
            $galeryiesUser->setNFT($this);
        }

        return $this;
    }

    public function removeGaleryiesUser(GaleryOfUser $galeryiesUser): static
    {
        if ($this->galeryiesUser->removeElement($galeryiesUser)) {
            // set the owning side to null (unless already changed)
            if ($galeryiesUser->getNFT() === $this) {
                $galeryiesUser->setNFT(null);
            }
        }

        return $this;
    }
}
