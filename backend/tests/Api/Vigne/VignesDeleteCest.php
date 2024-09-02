<?php

namespace App\Tests\Api\Vigne;

use App\Factory\AdminFactory;
use App\Factory\VigneFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class VignesDeleteCest
{
    public function anonymousdeletevignes(ApiTester $I)
    {
        ViticulteurFactory::createMany(8);
        VigneFactory::createOne();
        $I->sendDelete('/api/vignes/1');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
    public function admindeletevignes(ApiTester $I)
    {
        ViticulteurFactory::createMany(8);
        VigneFactory::createOne();
        $admin = AdminFactory::createOne();
        $I->amLoggedInAs($admin->object());
        $I->sendDelete('/api/vignes/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
    public function viticulteurdeletevignes(ApiTester $I)
    {
        $user = ViticulteurFactory::createOne();
        VigneFactory::createOne();
        $I->amLoggedInAs($user->object());
        $I->sendDelete('/api/vignes/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}