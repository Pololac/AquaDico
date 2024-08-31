<?php

namespace App\DataFixtures;

use App\Entity\Fish;
use App\Entity\FishFamily;
use App\Entity\Origin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_CARDS = 50;
    private const ORIGIN_NAMES = ['Amérique du Nord', 'Amérique du Sud', 'Amérique centrale', 'Europe', 'Afrique', 'Asie'];
    private const FISHFAMILY_NAMES = ['Cyprinidés', 'Cichlidés', 'Poeciliidés', 'Notobranchiidés'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');



        // --ORIGINES-----------------------------
        $origins = [];

        foreach (self::ORIGIN_NAMES as $originName) {
            $origin = new Origin();
            $origin->setContinent($originName);

            $manager->persist($origin);

            $origins[] = $origin;   
        }


        // --FAMILLES DE POISSONS-----------------------------
        $fishfamilies = [];

        foreach (self::FISHFAMILY_NAMES as $fishfamilyName) {
            $fishfamily = new FishFamily();
            $fishfamily->setName($fishfamilyName);

            $manager->persist($fishfamily);

            $fishfamilies[] = $fishfamily;   
        }


        // --FICHES-----------------------------
        for ($i = 0; $i < self::NB_CARDS; $i++) {
            $fish = new Fish();
            $fish
                ->setName($faker->word())
                ->setLatinName($faker->sentence(2))
                ->setDescription($faker->paragraphs(3, true))
                ->setAdultSize($faker->randomDigitNotNull())
                ->setMinTemp($faker->numberBetween(10, 30))
                ->setMaxTemp($faker->numberBetween(10, 30))
                ->setMinPh($faker->randomFloat(1, 1, 14))
                ->setMaxPh($faker->randomFloat(1, 1, 14))
                ->setMinGh($faker->numberBetween(1, 34))
                ->setMaxGh($faker->numberBetween(1, 34))
                ->setOrigin($faker->randomElement($origins))
                ->setFamily($faker->randomElement($fishfamilies));

            $manager->persist($fish);
        }

        $manager->flush();
    }
}
