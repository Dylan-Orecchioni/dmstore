<?php

namespace App\Entity;

use App\Repository\ContentListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentListRepository::class)
 */
class ContentList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CommandeListProduct::class, inversedBy="contentLists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $listProduct;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="contentList", orphanRemoval=true)
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListProduct(): ?CommandeListProduct
    {
        return $this->listProduct;
    }

    public function setListProduct(?CommandeListProduct $listProduct): self
    {
        $this->listProduct = $listProduct;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setContentList($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getContentList() === $this) {
                $product->setContentList(null);
            }
        }

        return $this;
    }
}
