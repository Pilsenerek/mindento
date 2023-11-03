<?php

namespace App\Tests\TripManage;

use App\Domain\TripManage\Entity\TripInterface;
use App\Domain\TripManage\Repository\TripRepositoryInterface;
use App\Domain\TripManage\TripService;
use PHPUnit\Framework\TestCase;

class TripServiceTest extends TestCase
{
    protected array $newTripCases = [
        [[], '2023-10-02 18:00:00', '2023-10-02 19:00:00', false],
        [[TripService::ERRORS['datesOrder']], '2023-10-02 20:00:00', '2023-10-02 06:00:00', false],
        [[TripService::ERRORS['theSameTime']], '2023-10-02 20:00:00', '2023-10-03 16:00:00', true],
    ];

    public function testAdd(): void
    {
        foreach ($this->newTripCases as $case) {
            $this->add($case[0], $case[1], $case[2], $case[3]);
        }
    }

    private function add(array $expected, string $dateStartStr, string $dateEndStr, bool $isDateTimeCollide): void
    {
        $tripRepo = $this->createMock(TripRepositoryInterface::class);
        $tripRepo->expects(self::any())->method('isDateTimeCollide')->willReturn($isDateTimeCollide);
        $trip = $this->createMock(TripInterface::class);
        $dateStart = \DateTime::createFromFormat('Y-m-d H:i:s', $dateStartStr);
        $trip->expects(self::any())->method('getDateTimeStart')->willReturn($dateStart);
        $dateEnd = \DateTime::createFromFormat('Y-m-d H:i:s', $dateEndStr);
        $trip->expects(self::any())->method('getDateTimeEnd')->willReturn($dateEnd);

        $tripService = new TripService($tripRepo);

        $this->assertEquals($expected, $tripService->add($trip));
    }

}
