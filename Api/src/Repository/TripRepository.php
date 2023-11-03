<?php

namespace App\Repository;

use App\Domain\TripAmountDue\Repository\TripRepositoryInterface as TripAmountDueRepositoryInterface;
use App\Domain\TripManage\Repository\TripRepositoryInterface as TripManageRepositoryInterface;
use App\Domain\TripAmountDue\Entity\TripInterface as TripAmountDueInterface;
use App\Domain\TripManage\Entity\TripInterface as TripManageInterface;
use App\Entity\Trip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trip>
 *
 * @method Trip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trip[]    findAll()
 * @method Trip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends ServiceEntityRepository implements TripAmountDueRepositoryInterface, TripManageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    /**
     * @return TripAmountDueInterface[]
     */
    public function findByWorker(int $workerId): array
    {
        return $this->findBy(['worker' => $workerId]);
    }

    public function add(TripManageInterface $trip): void
    {
        $this->getEntityManager()->persist($trip);
        $this->getEntityManager()->flush();
    }

    public function isDateTimeCollide(TripManageInterface $trip): bool
    {
        $qb = $this->createQueryBuilder('t');
        $qb->andWhere('t.worker = :worker');

        $qb->andWhere(
            $qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->gte('t.dateTimeStart', ':dateTimeStart'),
                    $qb->expr()->lt('t.dateTimeStart', ':dateTimeEnd')
                ),
                $qb->expr()->andX(
                    $qb->expr()->lt('t.dateTimeStart', ':dateTimeStart'),
                    $qb->expr()->gt('t.dateTimeEnd', ':dateTimeStart')
                )
            )
        );

        $qb->setParameter('worker', $trip->getWorker());
        $qb->setParameter('dateTimeStart', $trip->getDateTimeStart()->format('Y-m-d H:i:s'));
        $qb->setParameter('dateTimeEnd', $trip->getDateTimeEnd()->format('Y-m-d H:i:s'));
        $result = $qb->getQuery()->getArrayResult();

        return (bool)count($result);
    }
}
