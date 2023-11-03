<?php

namespace App\Entity;

use App\Domain\TripAmountDue\Entity\CountryInterface as TripAmountDueCountryInterface;
use App\Domain\TripManage\Entity\CountryInterface as TripManageCountryInterface;
use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country implements TripAmountDueCountryInterface, TripManageCountryInterface
{
    #[ORM\Id]
    #[ORM\Column(length: 2)]
    private ?string $code = null;

    #[ORM\Column(length: 3)]
    private ?string $currency = null;

    #[ORM\Column]
    private ?float $amountRate = null;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getAmountRate(): ?float
    {
        return $this->amountRate;
    }

    public function setAmountRate(float $amountRate): static
    {
        $this->amountRate = $amountRate;

        return $this;
    }
}
