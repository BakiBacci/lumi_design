<?php

namespace App\Controller\Admin;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/produit', name: 'admin_product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ProductRepository $repository, Request $request): Response
    {
        $pagination = $repository->paginateProducts($request->query->getInt('page', 1));

        return $this->render('admin/product/index.html.twig', [
            'products' => $pagination
        ]);
    }
}
