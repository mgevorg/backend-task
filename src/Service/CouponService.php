<?php

namespace App\Service;

use App\Entity\Coupon;

class CouponService {
    public function applyCoupon(Coupon $coupon, float $price): float
    {
        if ($coupon->getDiscountType() === 'percentage') {
            return $price - ($price * ($coupon->getDiscountValue() / 100));
        }

        return $coupon->getDiscountValue() < $price ? $price - $coupon->getDiscountValue() : 0;
    }
}
