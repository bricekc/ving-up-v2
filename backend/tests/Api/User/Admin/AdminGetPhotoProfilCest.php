<?php

namespace App\Tests\Api\User\Admin;

use App\Factory\AdminFactory;
use App\Tests\Support\ApiTester;

class AdminGetPhotoProfilCest
{
    public function getPhotoProfilForViticulteur(ApiTester $I): void
    {
        $viti = AdminFactory::createOne();

        $I->sendGet('/api/users/1/avatar');

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'image/jpeg');
        $I->seeResponseContains(stream_get_contents($viti->getPhotoProfil(), -1, 0));
    }
}