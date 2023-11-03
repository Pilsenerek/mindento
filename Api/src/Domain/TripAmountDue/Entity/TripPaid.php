<?php

namespace App\Domain\TripAmountDue\Entity;


class TripPaid
{
    protected string $start;
    protected string $end;
    protected string $country;
    protected float $amountDue;
    protected string $currency;

    public function getStart(): string
    {
        return $this->start;
    }

    public function setStart(string $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): string
    {
        return $this->end;
    }

    public function setEnd(string $end): void
    {
        $this->end = $end;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getAmountDue(): float
    {
        return $this->amountDue;
    }

    public function setAmountDue(float $amountDue): void
    {
        $this->amountDue = $amountDue;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

}
