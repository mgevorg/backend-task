<?php

namespace App\Service\Payment;

use App\Contract\PaymentServiceInterface;

class PaypalService implements PaymentServiceInterface {
    public function processPayment(float $amount): bool {
        return true; 
    }
}