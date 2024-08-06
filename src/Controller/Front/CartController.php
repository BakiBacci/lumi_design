<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/panier', name: 'front_cart_')]
class CartController extends AbstractController
{
    #[Route('/front/cart', name: 'index', methods: ['GET'])]
    public function index(CartService $cartService): Response
    {
        $dataCart = $cartService->getCartContent();

        return $this->render('front/cart/index.html.twig', [
            'dataCart' => $dataCart,
        ]);
    }

    #[Route('/ajouter/{id}', name: 'add', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function add(int $id, SessionInterface $session): Response
    {
        // incrementProductQuantity
        
        // $cart = $session->get('cart', []);

        // if (!isset($cart[$id])) {
        //     $cart[$id] = 1;
        // } else {
        //     $cart[$id]++;
        // }

        // $session->set('cart', $cart);

        return $this->redirectToRoute('front_cart_index');
    }

    #[Route('/diminuer/{id}', name: 'decrease', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function decrease(int $id, SessionInterface $session): Response
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

    #[Route('/supprimer/{id}', name: 'remove', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function remove($id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('front_cart_index');
    }

    #[Route('/vider', name: 'empty', methods: ['GET'])]
    public function empty(SessionInterface $session, Request $request): Response
    {
        $session->remove('cart');

        return $this->redirectToRoute('front_cart_index');
    }
}
