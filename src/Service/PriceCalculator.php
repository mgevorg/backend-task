<?php
namespace App\Service;

use App\Entity\Product;
use App\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;

class PriceCalculator
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function calculatePrice(int $productId, string $taxNumber, ?string $couponCode): float
    {
        $product = $this->em->getRepository(Product::class)->find($productId);
        $coupon = $couponCode ? $this->em->getRepository(Coupon::class)->findOneBy(['code' => $couponCode]) : null;

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $price = $product->getPrice();
        $tax = $this->calculateTax($taxNumber);
        $priceWithTax = $price + ($price * $tax);

        if ($coupon) {
            $priceWithTax = $this->applyCoupon($coupon, $priceWithTax);
        }

        return $priceWithTax;
    }

    private function calculateTax(string $taxNumber): float
    {
        if (preg_match('/^DE/', $taxNumber)) {
            return 0.19;
        } elseif (preg_match('/^IT/', $taxNumber)) {
            return 0.22;
        } elseif (preg_match('/^FR/', $taxNumber)) {
            return 0.20;
        } elseif (preg_match('/^GR/', $taxNumber)) {
            return 0.24;
        }

        return 0.0;
    }

    private function applyCoupon(Coupon $coupon, float $price): float
    {
        if ($coupon->getDiscountType() === 'percentage') {
            return $price - ($price * ($coupon->getDiscountValue() / 100));
        }

        return $price - $coupon->getDiscountValue();
    }
}