<?php

namespace App\Domain\TripAmountDue\Repository;

use App\Domain\TripAmountDue\Entity\TripInterface;

interface TripRepositoryInterface
{
    /**
     * @return TripInterface[]
     */
    public function findByWorker(int $workerId) : array;
}
