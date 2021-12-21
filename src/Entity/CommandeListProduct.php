<?php

namespace App\Entity;

use App\Repository\CommandeListProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeListProductRepository::class)
 */
class CommandeListProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Commande::class, inversedBy="commandeListProduct", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\OneToMany(targetEntity=ContentList::class, mappedBy="listProduct")
     */
    private $contentLists;

    public function __construct()
    {
        $this->contentLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * @return Collection|ContentList[]
     */
    public function getContentLists(): Collection
    {
        return $this->contentLists;
    }

    public function addContentList(ContentList $contentList): self
    {
        if (!$this->contentLists->contains($contentList)) {
            $this->contentLists[] = $contentList;
            $contentList->setListProduct($this);
        }

        return $this;
    }

    public function removeContentList(ContentList $contentList): self
    {
        if ($this->contentLists->removeElement($contentList)) {
            // set the owning side to null (unless already changed)
            if ($contentList->getListProduct() === $this) {
                $contentList->setListProduct(null);
            }
        }

        return $this;
    }
}
