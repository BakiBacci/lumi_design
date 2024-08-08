<?php

namespace App\Service;

use App\Entity\OrderItem;
use App\Entity\Orders;
use App\Entity\User;
use App\Repository\ProductRepository;

class OrderService
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function createOrder(User $user, array $cart)
    {
        $order = new Orders();
        $order->setCustomer($user);

        foreach ($cart as $key => $value) {
            $product = $this->repository->find($key);
            $price = $product->getPrice();

            $orderItem = new OrderItem();
            $orderItem->setQuantity($value);
            $orderItem->setPrice($price);
            $orderItem->setProduct($product);
            $order->addOrderItem($orderItem);
        }

        return $order;
    }
}
