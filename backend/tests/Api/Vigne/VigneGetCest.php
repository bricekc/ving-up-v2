<?php

namespace App\Tests\Api\Vigne;

use App\Factory\VigneFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;

class VigneGetCest
{
    public function VigneGetCest(ApiTester $I): void
    {
        ViticulteurFactory::createOne();
        $vigne = VigneFactory::createOne();
        $I->sendGet('/api/vignes/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'superficie' => $vigne->getSuperficie(),
            'latitude' => $vigne->getLatitude(),
            'longitude' => $vigne->getLongitude(),
        ]);
    }
}
