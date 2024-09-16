<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\PriceCalculator;
use App\Service\PaymentProcessor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Request\CalculatePriceRequest;
use App\Request\PurchaseRequest;

class ProductController extends AbstractController
{
    private PriceCalculator $priceCalculator;
    private PaymentProcessor $paymentProcessor;

    public function __construct(PriceCalculator $priceCalculator, PaymentProcessor $paymentProcessor)
    {
        $this->priceCalculator = $priceCalculator;
        $this->paymentProcessor = $paymentProcessor;
    }

    public function calculatePrice(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $requestData = json_decode($request->getContent(), true);
        $calculatePriceRequest = new CalculatePriceRequest($requestData);
        
        $errors = $validator->validate($calculatePriceRequest);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }
        try {
            $price = $this->priceCalculator->calculatePrice($data['product'], $data['taxNumber'], $data['couponCode']);
            return new JsonResponse(['price' => $price], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    public function purchase(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $requestData = json_decode($request->getContent(), true);
        $purchaseRequest = new PurchaseRequest($requestData);
        
        $errors = $validator->validate($purchaseRequest);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }
        try {
            $price = $this->priceCalculator->calculatePrice($data['product'], $data['taxNumber'], $data['couponCode']);
            $this->paymentProcessor->processPayment($data['paymentProcessor'], $price);
            return new JsonResponse(['message' => 'Payment successful'], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
