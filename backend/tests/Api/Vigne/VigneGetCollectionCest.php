<?php

namespace App\Tests\Api\Vigne;

use App\Factory\VigneFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;

class VigneGetCollectionCest
{
    public function VigneGetCollectionCest(ApiTester $I): void
    {
        ViticulteurFactory::createMany(8);
        VigneFactory::createMany(8);
        $I->sendGet('/api/vignes');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}