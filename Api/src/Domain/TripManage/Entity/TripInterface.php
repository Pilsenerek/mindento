<?php

namespace App\Domain\TripManage\Entity;

interface TripInterface
{
    public function getWorker(): ?WorkerInterface;

    public function setWorker(?WorkerInterface $worker): static;

    public function getCountry(): ?CountryInterface;

    public function setCountry(?CountryInterface $country): static;

    public function getDateTimeStart(): ?\DateTimeInterface;

    public function setDateTimeStart(\DateTimeInterface $dateTimeStart): static;

    public function getDateTimeEnd(): ?\DateTimeInterface;

    public function setDateTimeEnd(\DateTimeInterface $dateTimeEnd): static;
}
