<?php

namespace App\Entity;

use App\Domain\Worker\Entity\WorkerInterface;
use \App\Domain\TripManage\Entity\WorkerInterface as TripMangeWorkerInterface;
use App\Repository\WorkerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkerRepository::class)]
class Worker implements WorkerInterface, TripMangeWorkerInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
