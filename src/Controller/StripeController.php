<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeListProduct;
use App\Entity\ContentList;
use Stripe\Stripe;
use App\Entity\User;
use Stripe\Checkout\Session;
use App\MesServices\CartService\CartService;
use Symfony\Component\Routing\Annotation\Route;
use App\MesServices\CartService\CartRealProduct;
use App\MesServices\CommandeService;
use App\MesServices\MailerService;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

class StripeController extends AbstractController
{
    /**
     * @Route("/create-checkout-session",name="create_checkout_session")
     */
    public function createSession(CartService $cartService)
    {

        /** @var User $user */
        $user = $this->getUser();

        Stripe::setApiKey('sk_test_51IBjOmJxItuCvN48kVDdR9Tg52Npf4IJydX0TFxyioJFxo5vdlObzoYYTmiVZ2BD2XqGQkvsWaj8UNNzEz3ekgMo00jPcW004c');

        $domain = 'https://dmstore.fr';

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
              'success_url' => $domain . '/redirectionConnectionAutomatique/' . $user->getId(),
              'cancel_url' => $domain . '/paiementechoue',
          ]);

          return $this->redirect($checkout_session->url);
        
    }

    /**
     * @Route("/redirectionConnectionAutomatique/{id}", name="redirection_connexion_auto")
     */
    public function redirectConnectAuto(int $id, UserRepository $userRepository, LoginLinkHandlerInterface $loginLinkHandler)
    {
        $user = $userRepository->find($id);

            // create a login link for $user this returns an instance
            // of LoginLinkDetails
            $loginLinkDetails = $loginLinkHandler->createLoginLink($user);
            $loginLink = $loginLinkDetails->getUrl();

            return $this->redirect($loginLink);
    }


    /**
     * @Route("/paiementreussi", name="payment_success")
     */
    public function paymentSuccess(CommandeService $commandeService ,CartService $cartService,EntityManagerInterface $em, MailerService $mailerService, CommandeRepository $commandeRepository)
    {
        /** @var User $user */
        $user = $this->getUser();

        $commandeService->create($user);


        $commande = $commandeRepository->findOneBy([
            'user' => $user,
        ],[
            'date' => 'DESC'
        ]);

        $commande->setIsPayed(true);

        $em->flush();

        $mailerService->sendCommandMail($commande, $user);
        

        $this->addFlash("success","Votre commande a bien été validée.");
        $cartService->emptyCart();
        return $this->redirectToRoute("cart_detail");
    }

    /**
     * @Route("/paiementechoue", name="payment_cancel")
     */
    public function paymentCancel()
    {
        $this->addFlash("danger","Votre commande n'a pas été validée. Une erreur s'est produite, veuillez reessayez.");
        return $this->redirectToRoute('cart_detail');
    }
}