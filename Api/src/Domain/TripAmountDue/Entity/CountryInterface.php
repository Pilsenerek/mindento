<?php

namespace App\Domain\TripAmountDue\Entity;


interface CountryInterface
{
    public function getCode(): ?string;

    public function getCurrency(): ?string;

    public function getAmountRate(): ?float;
}
