<?php 

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adress;
use App\Form\AddressType;
use App\Form\AdressOrderType;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\CartService\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecapOrderController extends AbstractController
{
    /**
     * @Route("customer/recap/order",name="recap_order")
     */
    public function recap(CartService $cartService,Request $request,
                            EntityManagerInterface $em)
    {
        $detailCart = $cartService->getDetailedCartItems();
        
        $totalCart = $cartService->getTotal();
        

        $address = new Adress();

        /** @var User $user */
        $user = $this->getUser();

        if($user)
        {
            if($user->getAdress())
            {
                $address = $user->getAdress();
            }
        }

        $form = $this->createForm(AdressOrderType::class,$address);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if(!$user->getAdress())
            {
                $address->setUser($user);
                $em->persist($address);
            }

            $this->addFlash("success","L'adresse a bien été configurée.");
            $em->flush();

            return $this->redirectToRoute("recap_order");
            
        }

        return $this->render("customer/recap_order.html.twig",[
            'detailCart' => $detailCart,
            'form' => $form->createView(),
            'totalCart' => $totalCart
        ]);
        
    }
}