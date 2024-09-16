<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = new Product();
        $product1->setName('Product 1');
        $product1->setPrice(19.99);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Product 2');
        $product2->setPrice(29.99);
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName('Product 3');
        $product3->setPrice(39.99);
        $manager->persist($product3);

        $manager->flush();
    }
}
