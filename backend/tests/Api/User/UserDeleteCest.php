<?php

namespace App\Tests\Api\User;

use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class UserDeleteCest
{
    public function ViticulteurCanDeleteHisAccount(ApiTester $I)
    {
        $user = ViticulteurFactory::createOne();
        $I->amLoggedInAs($user->object());

        $I->sendDelete('/api/users/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    public function FournisseurCanDeleteHisAccount(ApiTester $I)
    {
        $user = FournisseurFactory::createOne();
        $I->amLoggedInAs($user->object());

        $I->sendDelete('/api/users/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    public function AdminCanDeleteViticulteurAndFournisseurAccount(ApiTester $I)
    {
        $user = AdminFactory::createOne();
        $I->amLoggedInAs($user->object());

        FournisseurFactory::createOne();
        ViticulteurFactory::createOne();

        $I->sendDelete('/api/users/2');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $I->sendDelete('/api/users/3');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    public function nonAdminUserCannotDeleteAnOtherAccount(ApiTester $I)
    {
        $user = FournisseurFactory::createOne();
        $I->amLoggedInAs($user->object());

        FournisseurFactory::createOne();
        $I->sendDelete('/api/users/2');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function anonymousUserCannotDeleteAnOtherAccount(ApiTester $I)
    {
        FournisseurFactory::createOne();
        $I->sendDelete('/api/users/1');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}