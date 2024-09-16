<?php
namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceRequest {
    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    public $product;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^(DE|IT|FR|GR)\d+$/", message="Invalid tax number")
     */
    public $taxNumber;

    /**
     * @Assert\Type("string")
     */
    public $couponCode;
}