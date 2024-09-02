<?php

namespace App\Tests\Api\Sujet;

use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\PostFactory;
use App\Factory\SujetFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class SujetDeleteCest
{
    public function anonymousUserForbiddenCannotDeleteSujet(ApiTester $I)
    {
        SujetFactory::createOne();
        $I->sendDelete('/api/sujets/1');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserCannotDeleteSujet(ApiTester $I)
    {
        $user = FournisseurFactory::createOne()->object();
        $I->amLoggedInAs($user);
        SujetFactory::createOne();
        $I->sendDelete('/api/sujets/1');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function adminUserCanDeleteSujet(ApiTester $I)
    {
        $user = AdminFactory::createOne()->object();
        $I->amLoggedInAs($user);
        SujetFactory::createOne();
        $I->sendDelete('/api/sujets/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    public function adminCanDeleteSujetWithPosts(ApiTester $I)
    {
        $user = AdminFactory::createOne()->object();
        $I->amLoggedInAs($user);
        SujetFactory::createOne();
        PostFactory::createMany(5);
        $I->sendDelete('/api/sujets/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
