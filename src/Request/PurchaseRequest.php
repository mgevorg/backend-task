<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest extends Request
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    public $product;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^(DE\d{9}|IT\d{11}|GR\d{9}|FR[A-Z]{2}\d{9})$/")
     */
    public $taxNumber;

    /**
     * @Assert\Type("string")
     */
    public $couponCode;

    /**
     * @Assert\NotBlank
     * @Assert\Choice({"paypal", "stripe"})
     */
    public $paymentProcessor;

    public function __construct(array $data) {
        $this->product = $data['product'] ?? null;
        $this->taxNumber = $data['taxNumber'] ?? null;
        $this->couponCode = $data['couponCode'] ?? null;
        $this->paymentProcessor = $data['paymentProcessor'] ?? null;
    }
}
