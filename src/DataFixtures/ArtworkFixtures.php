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
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $artwork = new Artwork();
            $artwork->setTitle($faker->sentence(4, true));
            $artwork->setHeight($faker->numberBetween(1, 50));
            $artwork->setWidth($faker->numberBetween(1, 50));
            $artwork->setDescription($faker->sentence(10));
            $artwork->setTechnique($faker->sentence(2));
            $artwork->setImageCover('https://picsum.photos/200');
            $artwork->setUser($this->getReference('artist_' . $faker->numberBetween(1, 2)));
            $artwork->setCategory($this->getReference('category_Peinture'));
            $artwork->setCreatedAt($faker->dateTime);




            $manager->persist($artwork);
        }
        $manager->flush();
    }


    public function getDependencies(): array
    {
        return[
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
