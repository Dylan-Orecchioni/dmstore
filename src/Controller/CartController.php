<?php 

namespace App\Controller;

use App\MesServices\CartService\CartItem;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("panier/ajout/{id}",name="add_product")
     */
    public function add(int $id, ProductRepository $productRepository,SessionInterface $session)
    {
        $product = $productRepository->find($id);

        if (!$product) 
        {
            $this->addFlash("danger", "Le produit est introuvable.");
            return $this->redirectToRoute('home');
        }
 
        $cart = $session->get('cart',[]);

        $qty = 1;

        foreach ($cart as $item) 
        {
            if ($item->getId() === $id) 
            {
                $qtyActuel = $item->getQty();

                $item->setQty($qtyActuel + $qty);

                $session->set('cart',$cart);

                $this->addFlash("success", "Le produit a bien été ajouté.");
                return $this->redirectToRoute('');
            }
        }

        $cartItem = new CartItem();
        $cartItem->setId($id);
        $cartItem->setQty($qty);

        $cart[] = $cartItem;

        $session->set('cart',$cart);

        $this->addFlash("success","Le produit a bien été ajouté.");
        return $this->redirectToRoute('');
    }
}