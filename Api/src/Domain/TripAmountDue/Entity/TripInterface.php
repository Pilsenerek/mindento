<?php

namespace App\Domain\TripAmountDue\Entity;

interface TripInterface
{
    public function getCountry(): ?CountryInterface;

    public function getDateTimeStart(): ?\DateTimeInterface;

    public function getDateTimeEnd(): ?\DateTimeInterface;
}
