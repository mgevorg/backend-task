<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\PriceCalculator;
use App\Service\PaymentProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    private PriceCalculator $priceCalculator;
    private PaymentProcessor $paymentProcessor;

    public function __construct(PriceCalculator $priceCalculator, PaymentProcessor $paymentProcessor)
    {
        $this->priceCalculator = $priceCalculator;
        $this->paymentProcessor = $paymentProcessor;
    }

    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $price = $this->priceCalculator->calculatePrice($data['product'], $data['taxNumber'], $data['couponCode']);
            return new JsonResponse(['price' => $price], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/purchase', methods: ['POST'])]
    public function purchase(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $price = $this->priceCalculator->calculatePrice($data['product'], $data['taxNumber'], $data['couponCode']);
            $this->paymentProcessor->processPayment($data['paymentProcessor'], $price);
            return new JsonResponse(['message' => 'Payment successful'], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
