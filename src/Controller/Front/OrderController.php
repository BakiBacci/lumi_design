<?php

namespace App\Controller\Front;

use App\Entity\Order;
use App\Service\CartService;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/commande', name: 'front_order_')]
class OrderController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $em, CartService $cartService, OrderService $orderService): Response
    {
        $user = $this->getUser();
        $cart = $cartService->getCart();

        if (empty($cart)) {
            $this->addFlash('warning', 'Votre panier est vide');
            return $this->redirectToRoute('front_cart_index');
        }

        $order = $orderService->createOrder($user, $cart);

        $em->persist($order);
        $em->flush();

        $cartService->emptyCart();

        $this->addFlash('success', 'la commande a été passé');
        // cette route attend un parametre dynamique 'id' comment lui passer avec une valeur
        return $this->redirectToRoute('front_order_confirmation', ['id' => $order->getId()]);
    }


    #[Route('/confirmation/{id}', name: 'confirmation', methods: ['GET'])]
    public function confirmation(Order $order)
    {
        return $this->render('front/order/confirmation.html.twig', [
            'order' => $order,
        ]);
    }

    // route
    // simuler que le paiement est true
    // passer le status de la commande sur payé
    // envoyer un mail a l'utilisateur detail de sa commande
    // creer une facture dans public/invoices new Dompdf()
}
