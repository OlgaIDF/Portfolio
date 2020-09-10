<?php

namespace App\DataFixtures;

use App\Entity\Projets;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $projet = new Projets();
        $projet->setNomSite('Xavier Dolan');
        $projet->setOutil('WordPress');
        $projet->setType('Site e-commerce');
        $projet->setDescription('vente de souvenirs liés au travail de l\'acteur et réalisateur Xavier Dolan');
        $projet->setImage('projet3.jpg');

        $manager->persist($projet);
        $manager->flush();
    }
}
