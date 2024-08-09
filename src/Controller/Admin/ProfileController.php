<?php

// src/Controller/Admin/ProfileController.php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\OrderRepository;

class ProfileController extends AbstractController
{
    public function index(OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        $orders = $orderRepository->findBy(['user' => $user]);

        return $this->render('admin/profile/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    public function show(int $id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($id);

        return $this->render('admin/profile/detail.html.twig', [
            'order' => $order,
        ]);
    }
}