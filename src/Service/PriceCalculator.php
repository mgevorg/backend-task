<?php
namespace App\Service;

use App\Entity\Product;
use App\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\TaxService;

class PriceCalculator
{

    public function __construct(
        private EntityManagerInterface $em,
        private TaxService $taxService,
        private CouponService $couponService
        )
    {

    }

    public function calculatePrice(int $productId, string $taxNumber, ?string $couponCode): float
    {
        $product = $this->em->getRepository(Product::class)->find($productId);
        $coupon = $couponCode ? $this->em->getRepository(Coupon::class)->findOneBy(['code' => $couponCode]) : null;

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $price = $product->getPrice();
        $tax = $this->taxService->calculateTax($taxNumber);
        $priceWithTax = $price + ($price * $tax);

        if ($coupon) {
            $priceWithTax = $this->couponService->applyCoupon($coupon, $priceWithTax);
        }

        return $priceWithTax;
    }
}