<?php

namespace App\DataFixtures;

use App\Entity\Status;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 100; ++$i) {
            $user = $this->getReference('user_' . random_int(1, 10) . '@user.com');
            $task = new Task();
            $user->addTask($task);

            $task->setUser($user)
                ->setTitle($this->faker->jobTitle())
                ->setDescription($this->faker->text(200))
                ->setStatus(Status::COMPLETED);
            $manager->persist($task);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
