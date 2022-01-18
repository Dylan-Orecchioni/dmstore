<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerHomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('customer/home.html.twig');
    }

    #[Route('/a_propos', name: 'a_propos')]
    public function about(): Response
    {
        return $this->render('customer/a_propos.html.twig');
    }

}
