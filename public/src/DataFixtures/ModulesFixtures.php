<?php

namespace App\DataFixtures;

use App\Entity\Modules;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ModulesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create modules
        $tournamentModule = (new Modules())
            ->setName('team');
        $manager->persist($tournamentModule);
        $tournamentModule = (new Modules())
            ->setName('tournament');
        $manager->persist($tournamentModule);

        $manager->flush();
    }
}
