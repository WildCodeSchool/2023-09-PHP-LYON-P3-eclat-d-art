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
        foreach (CategoryFixtures:: CATEGORY as $category) {
            $faker = Factory::create();
            for ($i = 0; $i < 50; $i++) {
                $artwork = new Artwork();
                $artwork->setTitle($faker->name());
                $artwork->setHeight($faker->randomDigit());
                $artwork->setWeight($faker->randomDigit());
                $artwork->setTechnique($faker->name());
                $artwork->setImageCover($faker->imageUrl());
                $artwork->setDescription($faker->sentence());
                $artwork->setUser($this->getReference('user_0'));
                $artwork->setCreatedAt(date_create('now'));
                $artwork->setCategory($this->getReference('category_' . $category));
                $manager->persist($artwork);
            }
        }
            $manager->flush();
    }


    public function getDependencies()
    {
        return[
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
