<?php

namespace App\DataFixtures;

use App\Entity\Continent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class ContinentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        // création de plusieurs produits
        for($i = 0; $i < 6; $i++) {
            // instanciation d'une entité
            $continent = new Continent();
            $continent->setName( $faker->unique()->word );

            // Références : Mise en mémoire d'objets réutilisables dans d'autres fixtures
            $this->addReference("continent$i", $continent);

            // doctrine : méthode persist permet de créer un enregistrement (INSERT INTO)
            $manager->persist($continent);
        }

        // doctrine : méthode flush permet d'exécuter les requêtes SQL (à exécuter une seule fois)
        $manager->flush();
    }
}
