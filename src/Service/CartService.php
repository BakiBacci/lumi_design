<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    public function __construct(private ProductRepository $repository, private RequestStack $requestStack)
    {
    }

    private function getSession()
    {
        return $this->requestStack->getSession();
    }

    public function getCartContent()
    {
        $cart = $this->getSession()->get('cart', []);
        $dataCart = [];

        foreach ($cart as $id => $quantity) {
            $product = $this->repository->find($id);
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

        return $dataCart;
    }
}
