<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WishFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->sentence(3));
            $wish->setDescription($faker->paragraph());
            $wish->setAuthor($faker->firstName());
            $wish->setIsPublished($faker->boolean(80)); // 80% de chance que ce soit publié
            $wish->setDateCreated(
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 years', 'now'))
            );
            $wish->setDateUpdated(new \DateTimeImmutable());
            $manager->persist($wish);
        }

        $manager->flush();
    }
}
