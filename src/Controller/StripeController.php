<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\User;
use Stripe\Checkout\Session;
use App\MesServices\CartService\CartService;
use Symfony\Component\Routing\Annotation\Route;
use App\MesServices\CartService\CartRealProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/create-checkout-session",name="create_checkout_session")
     */
    public function createSession(CartService $cartService)
    {
        Stripe::setApiKey('sk_test_51IBjOmJxItuCvN48kVDdR9Tg52Npf4IJydX0TFxyioJFxo5vdlObzoYYTmiVZ2BD2XqGQkvsWaj8UNNzEz3ekgMo00jPcW004c');

        $domain = 'http://127.0.0.1:8000';

        /** @var User $user */
        $user = $this->getUser();

        /** @var CartRealProduct[] $detailcart */
        $detailcart = $cartService->getDetailedCartItems();

        $productForStripe = [];

        foreach ($detailcart as $item) 
        {
            $productForStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->getProduct()->getPrice(),
                    'product_data' => [
                        'name' => $item->getProduct()->getName(),
                        'images' => [
                            $domain . $item->getProduct()->getImagePath()]
                    ]
                ],
                'quantity' => $item->getQty()
            ];
        }
        
        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            'payment_method_types' => [
                'card',
            ],
            'line_items' => [
                $productForStripe
            ],
            'mode' => 'payment',
              'success_url' => $domain . '/paiementreussi',
              'cancel_url' => $domain . '/paiementechoue',
          ]);

          return $this->redirect($checkout_session->url);
        

    }

    /**
     * @Route("/paiementreussi", name="payment_success")
     */
    public function paymentSuccess(CartService $cartService)
    {
        $this->addFlash("success","Votre commande a bien été pris en compte.");
        $cartService->emptyCart();
        return $this->redirectToRoute("cart_detail");
    }

    /**
     * @Route("/paiementechoue", name="payment_cancel")
     */
    public function paymentCancel()
    {
        $this->addFlash("danger","Votre commande n'a pas été validé. Une erreur s'est produite, veuillez reessayez.");
        return $this->redirectToRoute('cart_detail');
    }
}