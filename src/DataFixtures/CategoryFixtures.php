<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $faker = Factory::create('fr_FR');
            $category = new Category();
            $category->setName($faker->name);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
