<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'subcategory:list'
            ]
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'subcategory:items'
            ]
        ],
    ],
)]
#[ApiFilter(
    SearchFilter::class, properties: [
    'name' => 'partial',

],
)]
class SubCategory implements SlugInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['subcategory:list', 'subcategory:items','nft:items', 'nft:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['subcategory:list', 'subcategory:items', 'nft:items', 'nft:list'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['subcategory:list', 'subcategory:items'])]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'subCategories')]
    #[Groups(['subcategory:list', 'subcategory:items'])]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'subCategory', targetEntity: NFT::class)]
    #[Groups(['subcategory:list', 'subcategory:items', 'nft:items', 'nft:list'])]
    private Collection $nfts;

    public function __construct()
    {
        $this->nfts = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, NFT>
     */
    public function getNfts(): Collection
    {
        return $this->nfts;
    }

    public function addNft(NFT $nft): static
    {
        if (!$this->nfts->contains($nft)) {
            $this->nfts->add($nft);
            $nft->setSubCategory($this);
        }

        return $this;
    }

    public function removeNft(NFT $nft): static
    {
        if ($this->nfts->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getSubCategory() === $this) {
                $nft->setSubCategory(null);
            }
        }

        return $this;
    }
}
