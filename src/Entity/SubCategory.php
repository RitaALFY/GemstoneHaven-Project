<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
class SubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'subCategories')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'subCategory', targetEntity: NFT::class)]
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
