<?php

namespace App\Tests\Api\User\Viticulteur;

use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;

class ViticulteurGetPhotoProfilCest
{
    public function getPhotoProfilForViticulteur(ApiTester $I): void
    {
        $viti = ViticulteurFactory::createOne();

        $I->sendGet('/api/users/1/avatar');

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'image/jpeg');
        $I->seeResponseContains(stream_get_contents($viti->getPhotoProfil(), -1, 0));
    }
}
