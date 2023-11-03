<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    protected array $countries = [
        ['PL', 'PLN', 10],
        ['DE', 'PLN', 50],
        ['GB', 'PLN', 75],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->countries as $countryData) {
            $country = new Country();
            $country->setCode($countryData[0]);
            $country->setCurrency($countryData[1]);
            $country->setAmountRate($countryData[2]);
            $manager->persist($country);
            $this->addReference('country_'.$country->getCode(), $country);
        }

        $manager->flush();
    }
}
