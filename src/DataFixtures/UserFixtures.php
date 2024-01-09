<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER = 'user';

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 5; $i++) {
            $user = new User();
            $user->setName('name' . $i);
            $user->setEmail('email' . $i);
            $user->setPassword('password' . $i);
            $user->setDescription('description' . $i);
            $user->setNationality('nationality' . $i);
            $user->setPhoto('photo' . $i);
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
