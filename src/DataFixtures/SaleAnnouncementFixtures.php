<?php

namespace App\DataFixtures;

use App\Factory\SaleAnnouncementFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SaleAnnouncementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        SaleAnnouncementFactory::createMany(30);

        $manager->flush();
    }
}
