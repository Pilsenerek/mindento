<?php

namespace App\DataFixtures;

use App\Entity\Trip;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TripFixtures extends Fixture implements DependentFixtureInterface
{
    protected array $trips = [
        ['2020-04-20 08:00:00', '2020-04-25 18:00:00', 1, 'PL'],
        ['2020-05-10 10:00:00', '2020-05-12 23:00:00', 2, 'DE'],
        ['2020-05-23 20:00:00', '2020-06-12 09:00:00', 3, 'GB'],
        ['2020-06-11 23:00:00', '2020-06-12 20:00:00', 4, 'GB'],
        ['2020-07-11 02:00:00', '2020-07-12 23:00:00', 5, 'GB'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->trips as $tripData) {
            $trip = new Trip();
            $trip->setDateTimeStart(\DateTime::createFromFormat('Y-m-d H:i:s', $tripData[0]));
            $trip->setDateTimeEnd(\DateTime::createFromFormat('Y-m-d H:i:s', $tripData[1]));
            $trip->setWorker($this->getReference('worker_' . $tripData[2]));
            $trip->setCountry($this->getReference('country_' . $tripData[3]));
            $manager->persist($trip);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
            WorkerFixtures::class
        ];
    }
}
