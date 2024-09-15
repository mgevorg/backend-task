<?php
namespace App\Service;

use App\Exception\PaymentException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentProcessor
{
    public function __construct(
        private PaypalPaymentProcessor $paypalPaymentProcessor = new PaypalPaymentProcessor(),
        private StripePaymentProcessor $stripePaymentProcessor = new StripePaymentProcessor(),
        )
    {

    }
    public function processPayment(string $processor, float $amount): void
    {
        try {
            if ($processor === 'paypal') {
                $this->paypalPaymentProcessor->pay($amount);
            } elseif ($processor === 'stripe') {
                $this->paypalPaymentProcessor->pay($amount);
            } else {
                throw new Exception('Invalid payment processor');

            }
        } catch (\Exception $e) {
            throw new Exception('Payment failed: ' . $e->getMessage());
        }
    }
}
