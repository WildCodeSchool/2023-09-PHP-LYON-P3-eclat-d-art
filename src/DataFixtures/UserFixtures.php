<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 50; $i++) {
            $faker = Factory::create();
            $user = new User();
            $user->setName($faker->name);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $user->setDescription($faker->paragraph(5));
            $user->setNationality($faker->country);
            $user->setPhoto($faker->imageUrl);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
