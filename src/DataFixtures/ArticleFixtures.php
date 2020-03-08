<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        // création de plusieurs produits
        for($i = 0; $i < 20; $i++) {
            // instanciation d'une entité
            $article = new Article();
            $article->setName( $faker->sentence(2) );
            $article->setDescription( $faker->text(150) );
            $article->setImage('default.jpg');


            // Récupération des références des catégories
            $randomContinent = random_int(0, 5);
            $continent = $this->getReference("continent$randomContinent");

            //associer la catégorie au produit
            $article->setContinent($continent);


            // doctrine : méthode persist permet de créer un enregistrement (INSERT INTO)
            $manager->persist($article);
        }

        // doctrine : méthode flush permet d'exécuter les requêtes SQL (à exécuter une seule fois)
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ContinentFixtures::class
        ];
    }


}
