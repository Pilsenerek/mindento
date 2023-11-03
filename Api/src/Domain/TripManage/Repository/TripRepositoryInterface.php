<?php

namespace App\Domain\TripManage\Repository;

use App\Domain\TripManage\Entity\TripInterface;

interface TripRepositoryInterface
{
    public function add(TripInterface $trip): void;

    public function isDateTimeCollide(TripInterface $trip): bool;
}
