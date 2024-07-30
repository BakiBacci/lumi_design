<?php

namespace App\Factory;

use App\Entity\Product;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Product>
 */
final class ProductFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        self::faker()->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider(self::faker()));
    }

    public static function class(): string
    {
        return Product::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'name' => self::faker()->text(10),
            'description' => self::faker()->text(255),
            'image' => self::faker()->imageUrl(width: 800, height: 600),
            'slug' => self::faker()->text(255),
            'stock' => 123,
            'category' => CategoryFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Product $product): void {})
        ;
    }
}
