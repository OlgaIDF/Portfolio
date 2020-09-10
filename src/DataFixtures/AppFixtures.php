<?php

namespace App\DataFixtures;

use App\Entity\Competences;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $competence = new Competences();
        $competence->setType('CMS');
        $competence->setNom('WordPress');
        $competence->setPicto('wordpress.jpg');
        

        $manager->persist($competence);
        $manager->flush();
    }
}
