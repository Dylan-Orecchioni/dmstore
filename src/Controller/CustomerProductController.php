<?php 

namespace App\Controller;

use App\Search\SearchProduct;
use App\Form\SearchProductType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerProductController extends AbstractController
{
    /**
     * @Route("customer/product/{id}", name="product_show_detail")
     */
    public function show(int $id,ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);

        if(!$product)
        {
            $this->addFlash("danger","Le produit est introuvable.");
            return $this->redirectToRoute("customer_home");
        }
        return $this->render("customer/product_show_detail.html.twig",[
            'product' => $product
        ]);
        
    }

    /**
     * @Route("customer/category/{idCategory}/{idTag}", name="customer_product_show")
     */
    public function index(int $idCategory,int $idTag,ProductRepository $productRepository,CategoryRepository $categoryRepository,TagRepository $tagRepository)
    {
        
        
        $category = $categoryRepository->find($idCategory);
        $tag = $tagRepository->find($idTag);
        
        if(!$category || !$tag)
        {
            return $this->redirectToRoute("home");
        }

        $products = $productRepository->findBy([
            'tag'=> $tag,
            'category' => $category
        ]);

        return $this->render("customer/product_show_all.html.twig",[
            'products' => $products
        ]);

    }
}