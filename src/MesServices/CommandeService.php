<?php

namespace App\MesServices;

use App\Entity\User;
use App\Entity\Commande;
use App\Entity\ContentList;
use App\Entity\CommandeListProduct;
use App\MesServices\CartService\CartService;
use Doctrine\ORM\EntityManagerInterface;

class CommandeService
{
    private $cartService;

    private $em;

    public function __construct(CartService $cartService, EntityManagerInterface $em)
    {
        $this->cartService = $cartService;
        $this->em = $em;
    }

    public function create(User $user)
    {
        $commande = $this->createCommande($user);

        $this->createCommandeListProduct($commande);

        $this->em->flush();
    } 

    private function createCommande(User $user)
    {
        $commande = new Commande();
        $commande->setUser($user);
        $commande->setTotal($this->cartService->getTotal());
        $this->em->persist($commande);
        return $commande;
    }

    private function createCommandeListProduct($commande)
    {
        $commandListProduct = new CommandeListProduct();
        $commandListProduct->setCommande($commande);
        
        /** @var CartRealProduct $detailcart */
        $detailcart = $this->cartService->getDetailedCartItems();
        
        foreach ($detailcart as $items) 
        {
            $contentList = new ContentList();
            $contentList->addProduct($items->getProduct());
            $contentList->setListProduct($commandListProduct);
            $contentList->setQty($items->getQty());
            $commandListProduct->addContentList($contentList);
            $this->em->persist($contentList);
            
        }
        $commande->setCommandeListProduct($commandListProduct);
        $this->em->persist($commandListProduct);
    }
}