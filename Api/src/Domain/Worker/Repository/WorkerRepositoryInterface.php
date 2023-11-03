<?php

namespace App\Domain\Worker\Repository;


use App\Domain\Worker\Entity\WorkerInterface;

interface WorkerRepositoryInterface
{
    public function add(): WorkerInterface;
}
