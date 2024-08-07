<?php

namespace App\Factory;

use App\Entity\Orders;
use App\Enum\OrdersStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Orders>
 */
final class OrdersFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Orders::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-3 years')),
            'paidAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-3 years')),
            'customer' => UserFactory::new(),
            'orderNumber' => strtoupper(self::faker()->unique()->bothify('??-#######')),
            'status' => OrdersStatus::PENDING,
            // que le status est des valeur random en fonction de son Enum
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Orders $orders): void {})
        ;
    }
}
