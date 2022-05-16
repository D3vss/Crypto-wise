<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     *@var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 50; $i++) {

            $user = new User();

            $user->setUsername($this->faker->userName())
                ->setEmail($this->faker->safeEmail())
                ->setPassword($this->faker->password());
            $manager->persist($user);
        }
        $manager->flush();
    }
}
