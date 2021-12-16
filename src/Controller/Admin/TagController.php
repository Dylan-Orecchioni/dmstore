<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TagController extends AbstractController
{

    #[Route('admin/tag/new/{id}', name: 'tag_new')]
    public function create(int $id,CategoryRepository $categoryRepository, EntityManagerInterface $em, Request $request)
    {
        $category = $categoryRepository->find($id);

        if (!$category) 
        {
            $this->addFlash("danger","Cette categorie n'existe pas");
            return $this->redirectToRoute("admin_home");
        }

        $tag = new Tag();

        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $tag->setCategory($category);

            $em->persist($tag);
            $em->flush();

            $this->addFlash("success","Ce tag a bien été enregistré.");
            return $this->redirectToRoute("tag_new",[
                "id" => $id
            ]);

        }

        return $this->renderForm('admin/tag/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
}