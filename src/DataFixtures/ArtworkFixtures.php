<?php

namespace App\DataFixtures;

use App\Entity\Artwork;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\Query\Expr\Func;
use Faker\Factory;
use Faker\Guesser\Name;

class ArtworkFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
    }


    public function getDependencies()
    {
        return[
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
