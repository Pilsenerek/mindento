<?php

namespace App\Entity;

use App\Domain\TripAmountDue\Entity\TripInterface as TripAmountDueInterface;
use App\Domain\TripManage\Entity\TripInterface as TripManageInterface;
use App\Domain\TripManage\Entity\CountryInterface as TripManageCountryInterface;
use App\Domain\TripManage\Entity\WorkerInterface as TripManageWorkerInterface;
use App\Repository\TripRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip implements TripAmountDueInterface, TripManageInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Worker $worker = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: 'code', nullable: false)]
    private ?Country $country = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTimeStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTimeEnd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorker(): ?Worker
    {
        return $this->worker;
    }

    public function setWorker(?TripManageWorkerInterface $worker): static
    {
        $this->worker = $worker;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?TripManageCountryInterface $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getDateTimeStart(): ?\DateTimeInterface
    {
        return $this->dateTimeStart;
    }

    public function setDateTimeStart(\DateTimeInterface $dateTimeStart): static
    {
        $this->dateTimeStart = $dateTimeStart;

        return $this;
    }

    public function getDateTimeEnd(): ?\DateTimeInterface
    {
        return $this->dateTimeEnd;
    }

    public function setDateTimeEnd(\DateTimeInterface $dateTimeEnd): static
    {
        $this->dateTimeEnd = $dateTimeEnd;

        return $this;
    }
}
