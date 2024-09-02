<?php

namespace App\DataFixtures;

use App\Factory\AdminFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AdminFactory::createOne([
            'email' => 'dio@example.com',
            'firstname' => 'Loëvann',
            'lastname' => 'Guegan',
            'password' => 'adminfloppa01',
            'photo_profil' => file_get_contents(__DIR__.'/img/dio@example.com.png'),
        ]);
    }
}
