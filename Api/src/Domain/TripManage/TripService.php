<?php

namespace App\Domain\TripManage;

use App\Domain\TripManage\Entity\TripInterface;
use App\Domain\TripManage\Repository\TripRepositoryInterface;

class TripService
{

    public const ERRORS = [
        'datesOrder' => 'Start dateTime should be earlier than end dateTime',
        'theSameTime' => 'Two trips in the same time are not allowed',
    ];

    public function __construct(protected TripRepositoryInterface $tripRepository)
    {
    }

    public function add(TripInterface $trip): array
    {
        $errors = $this->validate($trip);
        if (count($errors) > 0) {

            return $errors;
        }

        $this->tripRepository->add($trip);

        return [];
    }

    private function validate(TripInterface $trip): array
    {
        $errors = [];
        if ($trip->getDateTimeStart() >= $trip->getDateTimeEnd()) {
            $errors[] = self::ERRORS['datesOrder'];
        }
        if ($this->tripRepository->isDateTimeCollide($trip)) {
            $errors[] = self::ERRORS['theSameTime'];
        }

        return $errors;
    }

}
