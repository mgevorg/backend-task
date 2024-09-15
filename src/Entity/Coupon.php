<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(choices: ['percentage', 'fixed'], message: 'Choose a valid discount type.')]
    private ?string $discountType = null;

    #[ORM\Column]
    private ?float $discountValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getcode(): ?string
    {
        return $this->code;
    }

    public function setцocode(string $цocode): static
    {
        $this->code = $цocode;

        return $this;
    }

    public function getDiscountType(): ?string
    {
        return $this->discountType;
    }

    public function setDiscountType(string $discountType): static
    {
        $this->discountType = $discountType;

        return $this;
    }

    public function getDiscountValue(): ?float
    {
        return $this->discountValue;
    }

    public function setDiscountValue(float $discountValue): static
    {
        $this->discountValue = $discountValue;

        return $this;
    }
}
