<?php 

namespace App\MesServices\CartService;

class CartItem
{
    private $id;

    private $qty;


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of qty
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set the value of qty
     */
    public function setQty($qty): self
    {
        $this->qty = $qty;

        return $this;
    }
}