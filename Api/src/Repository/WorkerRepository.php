<?php

namespace App\Repository;

use App\Domain\Worker\Entity\WorkerInterface;
use App\Domain\Worker\Repository\WorkerRepositoryInterface;
use App\Entity\Worker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Worker>
 *
 * @method Worker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Worker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Worker[]    findAll()
 * @method Worker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkerRepository extends ServiceEntityRepository implements WorkerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Worker::class);
    }

    public function add(): WorkerInterface
    {
        $worker = new Worker();
        $this->getEntityManager()->persist($worker);
        $this->getEntityManager()->flush();

        return $worker;
    }
}
