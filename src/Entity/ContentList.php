<?php

namespace App\Entity;

use App\Repository\ContentListRepository;
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
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="contentLists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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
}
