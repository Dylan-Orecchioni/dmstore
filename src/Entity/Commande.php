<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity=CommandeListProduct::class, mappedBy="commande", cascade={"persist", "remove"})
     */
    private $commandeListProduct;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPayed = false;

    public function __construct()
    {
        if(empty($this->date))
        {
            $this->date = new DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCommandeListProduct(): ?CommandeListProduct
    {
        return $this->commandeListProduct;
    }

    public function setCommandeListProduct(CommandeListProduct $commandeListProduct): self
    {
        // set the owning side of the relation if necessary
        if ($commandeListProduct->getCommande() !== $this) {
            $commandeListProduct->setCommande($this);
        }

        $this->commandeListProduct = $commandeListProduct;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getIsPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): self
    {
        $this->isPayed = $isPayed;

        return $this;
    }
}
