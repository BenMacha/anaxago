<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class UserFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        //create Admin
        $admin = new User();
        $admin
            ->setFirstName('Admin')
            ->setLastName('Admin')
            ->setRoles(array('ROLE_ADMIN'))
            ->setEmail('admin@admin.com')
            ->setPassword('password');
        $manager->persist($admin);

        //Create other Users
        for ($i = 1; $i <= 10; ++$i) {
            $user = new User();
            $user
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName());

            $manager->persist($user);
        }

        $manager->flush();
    }
}
