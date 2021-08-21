<?php

namespace App\DataFixtures;

use App\Entity\ModelManga;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModelMangaFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       

        $manager->flush();
    }
}
