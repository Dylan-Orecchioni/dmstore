<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    #[Route('/admin/home', name: 'admin_home')]
    public function index(): Response
    {
        $users = $this->getUser();

        return $this->render('admin/home_admin.html.twig', [
            'user' => $users
        ]);
    }
}
