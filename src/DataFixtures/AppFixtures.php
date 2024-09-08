<?php

namespace App\DataFixtures;

use App\Entity\Fish;
use App\Entity\FishFamily;
use App\Entity\Origin;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class AppFixtures extends Fixture
{
    private const NB_CARDS = 50;
    private const ORIGIN_NAMES = ['Amérique du Nord', 'Amérique du Sud', 'Amérique centrale', 'Europe', 'Afrique', 'Asie'];
    private const FISHFAMILY_NAMES = ['Cyprinidés', 'Cichlidés', 'Poeciliidés', 'Notobranchiidés'];

    public function __construct(
        private UserPasswordHasherInterface $hasher, 
        private SluggerInterface $slugger
    ){}
    
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

            // Générer un slug à partir du nom de la famille de poissons
            $slug = $this->slugger->slug($fishfamilyName)->lower();
            $fishfamily->setSlug($slug);

            $manager->persist($fishfamily);

            $fishfamilies[] = $fishfamily;   
        }


        // --FICHES-----------------------------
        for ($i = 0; $i < self::NB_CARDS; $i++) {
            $fish = new Fish();
            $fish
                ->setName($faker->words(2, true))
                ->setLatinName($faker->sentence(2))
                ->setDescription($faker->paragraphs(3, true))
                ->setAdultSize($faker->randomDigitNotNull())
                ->setMinTemp($minTemp = $faker->numberBetween(10, 30))
                ->setMaxTemp($faker->numberBetween($minTemp, 30))
                ->setMinPh($minPh = $faker->randomFloat(1, 1, 14))
                ->setMaxPh($faker->randomFloat(1, $minPh, 14))
                ->setMinGh($minGh = $faker->numberBetween(1, 34))
                ->setMaxGh($faker->numberBetween($minGh, 34))
                ->setOrigin($faker->randomElement($origins))
                ->setFamily($faker->randomElement($fishfamilies));

            $manager->persist($fish);
        }

        $manager->flush();

        // --USERS-----------------------------
        $admin = new User();
        $admin
            ->setEmail("admin@test.com")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this -> hasher ->hashPassword($admin, "admin1234"));

        $manager->persist($admin);

        $user = new User();
        $user
            ->setEmail("user@test.com")
            ->setPassword($this -> hasher ->hashPassword($user, "user1234"));

        $manager->persist($user);

        $manager->flush();

    }
}
