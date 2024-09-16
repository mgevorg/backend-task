<?php

namespace App\Service;

class TaxService {
    private const TAX_RATES = [
        'DE' => 0.19,
        'IT' => 0.22,
        'FR' => 0.20,
        'GR' => 0.24,
    ];

    public function calculateTax(string $taxNumber): float {
        $countryCode = substr($taxNumber, 0, 2);
        return self::TAX_RATES[$countryCode] ?? 0;
    }
}
