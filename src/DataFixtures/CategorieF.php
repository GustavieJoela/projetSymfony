<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieF extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1;$i<21;$i++){
            $cat = new Categorie();
            $cat->setLibelle("Categorie".$i);
            $cat->setCreateAt(new \DateTime());
            $manager->persist($cat);
        }
        $manager->flush();
    }
}
