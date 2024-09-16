<?php

namespace App\Service\Payment;

use App\Contract\PaymentServiceInterface;

class StripeService implements PaymentServiceInterface {
    public function processPayment(float $amount): bool {
        return true; 
    }
}