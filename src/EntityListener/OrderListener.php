<?php

namespace App\EntityListener;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: 'prePersist', entity: Orders::class, method: 'onPrePersist')]
class OrderListener
{
    public function onPrePersist(Orders $order, LifecycleEventArgs $args)
    {
        $orderNumber = 'LD-ORD-' . date('Ymdhis') . mt_rand(0, 1000);
        $order->setOrderNumber($orderNumber);
    }
}
