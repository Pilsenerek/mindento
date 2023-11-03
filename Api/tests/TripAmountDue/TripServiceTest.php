<?php

namespace App\Tests\TripAmountDue;

use App\Domain\TripAmountDue\Entity\CountryInterface;
use App\Domain\TripAmountDue\Entity\TripInterface;
use App\Domain\TripAmountDue\Entity\TripPaid;
use App\Domain\TripAmountDue\Repository\TripRepositoryInterface;
use App\Domain\TripAmountDue\TripService;
use PHPUnit\Framework\TestCase;

class TripServiceTest extends TestCase
{
    protected array $amountDueCases = [
        //one day
        [0, '2023-10-02 01:00:00', '2023-10-02 02:00:00'],
        [0, '2023-10-02 18:00:00', '2023-10-02 19:00:00'],
        [0, '2023-10-02 20:00:00', '2023-10-02 06:00:00'],
        [10, '2023-10-02 10:00:00', '2023-10-02 18:00:00'],
        //few days
        [0, '2023-10-02 18:00:00', '2023-10-03 07:00:00'],
        [20, '2023-10-02 16:00:00', '2023-10-03 08:00:00'],
        [0, '2023-10-06 18:00:00', '2023-10-09 07:00:00'],
        [20, '2023-10-06 16:00:00', '2023-10-09 08:00:00'],
        [10, '2023-10-06 18:00:00', '2023-10-10 07:00:00'],
        //one week
        [40, '2023-10-06 23:00:00', '2023-10-13 03:00:00'],
        [60, '2023-10-06 08:00:00', '2023-10-13 23:00:00'],
        //week+
        [50, '2023-10-06 23:00:00', '2023-10-16 07:00:00'],
        [60, '2023-10-06 03:00:00', '2023-10-16 07:00:00'],
        [70, '2023-10-06 21:00:00', '2023-10-17 03:00:00'],
        [80, '2023-10-06 03:00:00', '2023-10-16 09:00:00'],
        [80, '2023-10-06 03:00:00', '2023-10-16 23:00:00'],
        [100, '2023-10-06 03:00:00', '2023-10-17 20:00:00'],
        [140, '2023-10-09 07:00:00', '2023-10-20 21:00:00'],
    ];

    public function testTripsByWorker(): void
    {
        foreach ($this->amountDueCases as $case) {
            $this->testTripsAmount($case[0], $case[1], $case[2]);
        }
    }

    private function testTripsAmount(float $expectedAmount, string $dateStartStr, string $dateEndStr)
    {
        $country = $this->createMock(CountryInterface::class);
        $country->expects(self::any())->method('getCode')->willReturn('PL');
        $country->expects(self::any())->method('getCurrency')->willReturn('PLN');
        $country->expects(self::any())->method('getAmountRate')->willReturn(10.00);

        $trip = $this->createMock(TripInterface::class);
        $trip->expects(self::any())->method('getCountry')->willReturn($country);
        $dateStart = \DateTime::createFromFormat('Y-m-d H:i:s', $dateStartStr);
        $trip->expects(self::any())->method('getDateTimeStart')->willReturn($dateStart);
        $dateEnd = \DateTime::createFromFormat('Y-m-d H:i:s', $dateEndStr);
        $trip->expects(self::any())->method('getDateTimeEnd')->willReturn($dateEnd);
        $trips = [$trip];

        $tripRepository = $this->createMock(TripRepositoryInterface::class);
        $tripRepository->expects(self::any())->method('findByWorker')->willReturn($trips);

        $tripService = new TripService($tripRepository);

        $this->assertInstanceOf(TripPaid::class, $tripService->tripsByWorker(1)[0]);
        $this->assertEquals($expectedAmount, $tripService->tripsByWorker(1)[0]->getAmountDue());
    }
}
