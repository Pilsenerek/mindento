<?php

namespace App\Domain\Worker;

use App\Domain\Worker\Entity\WorkerInterface;
use App\Domain\Worker\Repository\WorkerRepositoryInterface;

class WorkerService
{
    public function __construct(
        protected WorkerRepositoryInterface $workerRepository,
    )
    {
    }

    public function addWorker(): WorkerInterface
    {
        return $this->workerRepository->add();
    }

}
