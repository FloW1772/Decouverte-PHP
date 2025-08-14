<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SerieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        //dd($faker->realText(maxNbChars: 30));

        for ($i = 0; $i < 1000; $i++) {
        $serie = new Serie();
        $serie->setName($faker->realText(maxNbChars: 30))
        ->setOverview($faker->paragraph(nbSentences: 2))
        ->setGenre($faker->randomElement(['Drama', 'Western', 'Comedy', 'Horror', 'Thriller']))
        ->setStatus($faker->randomElement(['Returning', 'Ended', 'Canceled']))
        ->setVote($faker->randomFloat(nbMaxDecimals: 2, min: 0,max: 10))
        ->setPopularity($faker->randomFloat(nbMaxDecimals: 2, min: 200,max: 900))
        ->setFirstAirDate($faker->dateTimeBetween('-10 year', '-1 month'))
        ->setDateCreated(new \DateTime())

            ;



        if ($serie->getStatus() === 'Returning') {
            $serie->setLastAirDate($faker->dateTimeBetween($serie->getFirstAirDate(), endDate: '-1 day'));
        }
        $manager->persist($serie);
    }
    $manager->flush();
  }
}
