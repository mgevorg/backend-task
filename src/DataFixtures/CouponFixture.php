<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Coupon;

class CouponFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $coupon1 = new Coupon();
        $coupon1->setCode('D5');
        $coupon1->setDiscountType('percentage');
        $coupon1->setDiscountValue(5.00);
        $manager->persist($coupon1);

        $coupon2 = new Coupon();
        $coupon2->setCode('D15');
        $coupon2->setDiscountType('fixed');
        $coupon2->setDiscountValue(14.99);
        $manager->persist($coupon2);

        $manager->flush();
    }
}
