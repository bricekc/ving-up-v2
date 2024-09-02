<?php

namespace App\Tests\Api\Post;

use App\Factory\AdminFactory;
use App\Factory\PostFactory;
use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class PostDeleteCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'texte' => 'string',
            'date' => 'string',
            'user' => 'string:path',
            'sujet' => 'string:path',
        ];
    }

    public function anonymousUserCannotDeletePost(ApiTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $I->sendDelete('/api/posts/1');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserCannotDeleteRandomPost(ApiTester $I)
    {
        ViticulteurFactory::createOne();
        SujetFactory::createOne();
        PostFactory::createOne();
        $user2 = ViticulteurFactory::createOne();
        $I->amLoggedInAs($user2->object());
        $I->sendDelete('/api/posts/1');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function adminUserCanDeletePost(ApiTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        PostFactory::createOne();
        $admin = AdminFactory::createOne();
        $I->amLoggedInAs($admin->object());
        $I->sendDelete('/api/posts/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    public function authenticatedUserCanDeleteHisPost(ApiTester $I)
    {
        $user = ViticulteurFactory::createOne();
        SujetFactory::createOne();
        PostFactory::createOne();
        $I->amLoggedInAs($user->object());
        $I->sendDelete('/api/posts/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
