<?php

namespace App\Tests\Api\User;

use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class UserGetMeCest
{
    public function anonymousMeIsUnauthorized(ApiTester $I): void
    {
        ViticulteurFactory::createOne();

        $I->sendGet('/api/me');

        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}