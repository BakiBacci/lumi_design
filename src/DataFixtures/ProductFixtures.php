<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create('fr_FR');
        $this->faker->addProvider(new \Faker\Provider\FakeCar($this->faker));
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $product = new Product();
            $product
                ->setName($this->faker->sentence(3))
                ->setSlug('lampe')
                ->setDescription('Description de produit ' . $i)
                ->setPrice($this->faker->randomFloat(2, 10, 100))
                ->setStock($this->faker->numberBetween(0, 1000))
                // ->setUpdatedAt($this->faker->dateTimeBetween())
                ->setCategory($this->getReference('CATEGORY' . mt_rand(0, 9)));

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
