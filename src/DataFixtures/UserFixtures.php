<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private Generator $faker;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // create Admin
        $admin = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'password'
        );

        $admin
            ->setFirstName('Admin')
            ->setLastName('Admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@admin.com')
            ->setPassword($hashedPassword);
        $manager->persist($admin);

        // Create other Users
        for ($i = 1; $i <= 10; ++$i) {
            $user = new User();

            $user
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setEmail('user_' . $i . '@user.com')
                ->setPassword($hashedPassword);
            $manager->persist($user);

            $this->addReference('user_' . $i . '@user.com', $user);
        }

        $manager->flush();
    }
}
