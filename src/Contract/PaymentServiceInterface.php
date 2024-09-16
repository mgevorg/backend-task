<?php

namespace App\Contract;

interface PaymentServiceInterface {
    public function processPayment(float $amount): bool;
}