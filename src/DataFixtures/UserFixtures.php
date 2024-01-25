<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('contributor@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setName('User');

        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            'user'
        );

        $contributor->setPassword($hashedPassword);
        $manager->persist($contributor);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setName("Admin");
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $artist1 = new User();
        $artist1->setEmail('artist1@monsite.com');
        $artist1->setRoles(['ROLE_CONTRIBUTOR']);
        $artist1->setName('artist_1');
        $this->addReference('artist_1', $artist1);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $artist1,
            'artist1'
        );
        $artist1->setPassword($hashedPassword);
        $manager->persist($artist1);

        $artist2 = new User();
        $artist2->setEmail('artist2@monsite.com');
        $artist2->setRoles(['ROLE_CONTRIBUTOR']);
        $artist2->setName('artist_2');
        $this->addReference('artist_2', $artist2);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $artist2,
            'artist2'
        );
        $artist2->setPassword($hashedPassword);
        $manager->persist($artist2);

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }
}
