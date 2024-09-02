<?php

namespace App\DataFixtures;

use App\Factory\RubriqueFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RubriqueFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
    }

    public function getDependencies(): array
    {
        return [
            AdminFixtures::class,
        ];
    }
}
