<?php

namespace App\Tests\Api\Vigne;

use App\Factory\VigneFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class VignesPostCest
{
    public function anonymousUserCreateVignes(ApiTester $I)
    {
        ViticulteurFactory::createOne();
        VigneFactory::createOne();
        $I->sendPost('/api/vignes', [
            'superficie' => 200,
            'latitude' => '200',
            'longitude' => '200',
            'user' => '/api/viticulteurs/1',
        ]);
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
    public function UserCreateVignes(ApiTester $I)
    {
        $user = ViticulteurFactory::createOne()->object();
        VigneFactory::createOne();
        $I->amLoggedInAs($user);
        $I->sendPost('/api/vignes', [
            'superficie' => 200,
            'latitude' => '200',
            'longitude' => '200',
            'user' => '/api/viticulteurs/1',
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson([
            'superficie' => 200,
            'latitude' => '200',
            'longitude' => '200',
        ]);
    }
}