<?php

namespace App\Domain\TripAmountDue;

use App\Domain\TripAmountDue\Entity\TripInterface;
use App\Domain\TripAmountDue\Entity\TripPaid;
use App\Domain\TripAmountDue\Repository\TripRepositoryInterface;

class TripService
{
    protected const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        protected TripRepositoryInterface   $tripRepository
    )
    {
    }

    /**
     * @return TripPaid[]
     */
    public function tripsByWorker(int $workerId): array
    {
        $trips = $this->tripRepository->findByWorker($workerId);
        $tripsPaid = [];
        foreach ($trips as $trip) {
            $tripPaid = new TripPaid();
            $tripPaid->setCountry($trip->getCountry()->getCode());
            $tripPaid->setCurrency($trip->getCountry()->getCurrency());
            $this->calcAmountDue($trip);
            $tripPaid->setAmountDue($this->calcAmountDue($trip));
            $tripPaid->setEnd($trip->getDateTimeEnd()->format(self::DATE_TIME_FORMAT));
            $tripPaid->setStart($trip->getDateTimeStart()->format(self::DATE_TIME_FORMAT));
            $tripsPaid[] = $tripPaid;
        }

        return $tripsPaid;
    }

    private function calcAmountDue(TripInterface $trip): float
    {
        $days = $this->calcDaysBetween($trip);
        $amountDues = 0;
        for ($d = 1; $d <= $days; $d++) {
            if ($d == 1) {
                $amountDues += $this->calcAmountDueFirstDay($trip);

                continue;
            }
            if ($d == $days) {
                $amountDues += $this->calcAmountDueLastDay($trip, $d);

                continue;
            }
            $amountDues += $this->calcAmountDueMiddleDays($trip, $d);
        }

        return $amountDues;
    }

    private function calcAmountDueFirstDay(TripInterface $trip): float
    {
        $dateTimeStart = $trip->getDateTimeStart();
        if (
            $this->calcTripLastInHours($trip) >= 8 &&
            !$this->isFreeDay($dateTimeStart) &&
            $this->calcHoursEndOfDay($dateTimeStart) >= 8) {

            return $trip->getCountry()->getAmountRate();
        }

        return 0;
    }

    private function calcTripLastInHours(TripInterface $trip): int
    {
        $diff = $trip->getDateTimeEnd()->diff($trip->getDateTimeStart());

        return $diff->h + ($diff->days * 24);
    }

    private function calcAmountDueLastDay(TripInterface $trip, int $currentDayNumber): float
    {
        $dateTimeEnd = $trip->getDateTimeEnd();
        if (!$this->isFreeDay($dateTimeEnd) && $this->calcHoursStartOfDay($dateTimeEnd) >= 8) {

            return $trip->getCountry()->getAmountRate() * $this->calcAmountMultiplier($currentDayNumber);
        }

        return 0;
    }

    private function calcAmountDueMiddleDays(TripInterface $trip, int $currentDayNumber): float
    {
        $currentDateTime = clone $trip->getDateTimeStart();
        $currentDateTime->modify('+' . ($currentDayNumber - 1) . ' day');
        if (!$this->isFreeDay($currentDateTime)) {

            return $trip->getCountry()->getAmountRate() * $this->calcAmountMultiplier($currentDayNumber);
        }

        return 0;
    }

    private function calcAmountMultiplier(int $currentDayNumber): int
    {
        if ($currentDayNumber > 8) {

            return 2;
        }

        return 1;
    }

    private function calcHoursEndOfDay(\DateTimeInterface $dateTime): int
    {
        $endOfDay = clone $dateTime;
        $endOfDay->setTime(24, 0);

        return $dateTime->diff($endOfDay)->h;
    }

    private function calcHoursStartOfDay(\DateTimeInterface $dateTime): int
    {
        $endOfDay = clone $dateTime;
        $endOfDay->setTime(0, 0);

        return $dateTime->diff($endOfDay)->h;
    }

    private function isFreeDay(\DateTimeInterface $dateTime): bool
    {
        $daysExcluded = [6, 7];

        return in_array($dateTime->format('N'), $daysExcluded);
    }

    private function calcDaysBetween(TripInterface $trip): int
    {
        $interval = \DateInterval::createFromDateString('1 day');
        $start = clone $trip->getDateTimeStart();
        $start->setTime(24, 0);
        $end = clone $trip->getDateTimeEnd();
        $end->setTime(24, 0);
        $period = new \DatePeriod($start, $interval, $end);

        return iterator_count($period) + 1;
    }
}
