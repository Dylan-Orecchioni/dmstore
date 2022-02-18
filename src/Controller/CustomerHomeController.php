<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerHomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $products = $productRepository->findAll();
        $formRegister = $this->createForm(RegistrationFormType::class);

        return $this->render('customer/home.html.twig', [
            'products' => $products,
            'registrationForm' => $formRegister->createView()
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('customer/about.html.twig');
    }

}
