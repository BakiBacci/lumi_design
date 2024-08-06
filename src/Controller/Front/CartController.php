<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/panier', name: 'front_cart_')]
class CartController extends AbstractController
{
    #[Route('/front/cart', name: 'index', methods: ['GET'])]
    public function index(SessionInterface $session, ProductRepository $repository): Response
    {
        $cart = $session->get('cart', []);
        $dataCart = [];

        foreach ($cart as $id => $quantity) {
            $product = $repository->find($id);
            if (!$product) {
                continue;
            }

            $total = $product->getPrice() * $quantity;

            $dataCart[] = [
                'product' => $product,
                'quantity' => $quantity,
                'total' => $total,
            ];
        }

        return $this->render('front/cart/index.html.twig', [
            'dataCart' => $dataCart,
        ]);
    }

    #[Route('/ajouter/{id}', name: 'add', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function add($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('front_cart_index');
    }

    #[Route('/diminuer/{id}', name: 'remove', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function remove($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id] = $cart[$id] - 1;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('front_cart_index');
    }
}
