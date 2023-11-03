<?php

namespace App\Domain\TripManage\Entity;


interface CountryInterface
{
    public function getCode(): ?string;

    public function setCode(string $code): static;

    public function getCurrency(): ?string;

    public function setCurrency(string $currency): static;

    public function getAmountRate(): ?float;

    public function setAmountRate(float $amountRate): static;
}
