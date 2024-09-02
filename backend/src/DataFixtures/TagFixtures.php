<?php

namespace App\DataFixtures;

use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $json = json_decode(file_get_contents(__DIR__.'/data/All_Tags.json'));
        foreach ($json as $name) {
            TagFactory::createOne((array) $name);
        }
    }
}
