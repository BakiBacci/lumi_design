<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('', name: 'front_home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ProductRepository $repository, Request $request): Response
    {
        $pagination = $repository->paginateProduct($request->query->getInt('page', 1));

        return $this->render('front/home/index.html.twig', [
            'products' => $pagination,
        ]);
    }

    // /detail/{slug} show
    // Affiche le details d'un produits


    // creer une route Controller\Admin  ProductController
    // /admin/produit     index
    // affiche la liste des produit sous forme d'un tableau
    //  Id  | Nom du Produit | date de creation | Modifier | Supprimer
    // il y aura une pagination

    // NOM_Prenom
}
