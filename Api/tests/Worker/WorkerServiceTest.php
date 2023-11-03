<?php

namespace App\Tests\Worker;

use App\Domain\Worker\Entity\WorkerInterface;
use App\Domain\Worker\Repository\WorkerRepositoryInterface;
use App\Domain\Worker\WorkerService;
use PHPUnit\Framework\TestCase;

class WorkerServiceTest extends TestCase
{

    public function testAddWorker(): void
    {
        $testWorkerId = 123;
        $worker = $this->createMock(WorkerInterface::class);
        $worker->expects(self::any())->method('getId')->willReturn($testWorkerId);

        $workerRepository = $this->createMock(WorkerRepositoryInterface::class);
        $workerRepository->expects(self::any())->method('add')->willReturn($worker);

        $workerService = new WorkerService($workerRepository);

        $this->assertInstanceOf(WorkerInterface::class, $workerService->addWorker());
        $this->assertEquals($testWorkerId, $workerService->addWorker()->getId());
    }

}
