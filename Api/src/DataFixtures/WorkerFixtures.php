<?php

namespace App\DataFixtures;

use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorkerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $worker = new Worker();
            $manager->persist($worker);
            $this->setReference('worker_' . $i, $worker);
        }

        $manager->flush();
    }
}
