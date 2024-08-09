<?php

namespace App\Controller\Front;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Service\CartService;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Constraints\Required;

#[IsGranted('IS_AUTHENTICATED')]
#[Route('/commande', name: 'front_order_')]
class OrderController extends AbstractController
{
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


    #[Route('/confirmation/{id}', name: 'confirmation', methods: ['GET'], requirements: ['id' => Requirement::POSITIVE_INT])]
    public function confirmation(int $id, OrderRepository $repository): Response
    {
        $order = $repository->findOrderWithRelations($id);

        return $this->render('front/order/confirmation.html.twig', [
            'order' => $order
        ]);
    }

    // route
    // simuler que le paiement est true
    // passer le status de la commande sur payé
    // envoyer un mail a l'utilisateur detail de sa commande
    // creer une facture dans public/invoices new Dompdf()
}
