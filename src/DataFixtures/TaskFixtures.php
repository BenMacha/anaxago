<?php

/**
 * PHP version 8.2 & Symfony 6.4.
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * https://www.php.net/license/3_01.txt.
 *
 * developed by Ben Macha.
 *
 * @category   Symfony Project ANAXAGOS
 *
 * @author     Ali BEN MECHA       <contact@benmacha.tn>
 *
 * @copyright  Ⓒ 2024 benmacha.tn
 *
 * @see       https://www.benmacha.tn
 *
 *
 */

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
