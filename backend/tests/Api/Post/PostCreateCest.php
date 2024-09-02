<?php

namespace App\Tests\Api\Post;

use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class PostCreateCest
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

    public function anonymousUserForbiddenCannotCreatePost(ApiTester $I)
    {
        ViticulteurFactory::createOne();
        SujetFactory::createOne();
        $I->sendPost('/api/posts', [
            'texte' => 'test',
            'date' => '2020-01-01',
            'user' => '/api/viticulteurs/1',
            'sujet' => '/api/sujets/1',
        ]);
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserCanCreatePost(ApiTester $I)
    {
        $user = ViticulteurFactory::createOne()->object();
        SujetFactory::createOne();
        $I->amLoggedInAs($user);
        $I->sendPost('/api/posts', [
            'texte' => 'test',
            'date' => '2020-01-01T00:00:00+01:00',
            'user' => '/api/viticulteurs/1',
            'sujet' => '/api/sujets/1',
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson([
            'texte' => 'test',
            'sujet' => '/api/sujets/1',
            'user' => '/api/viticulteurs/1',
        ]);
    }

    public function authenticatedUserCanCreatePostWithoutPropertiesUser(ApiTester $I)
    {
        $user = ViticulteurFactory::createOne()->object();
        SujetFactory::createOne();
        $I->amLoggedInAs($user);
        $I->sendPost('/api/posts', [
            'texte' => 'test',
            'date' => '2020-01-01T00:00:00+01:00',
            'sujet' => '/api/sujets/1',
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }

    public function authenticatedUserCanCreatePostWithoutPropertiesUserAndDate(ApiTester $I)
    {
        $user = ViticulteurFactory::createOne()->object();
        SujetFactory::createOne();
        $I->amLoggedInAs($user);
        $I->sendPost('/api/posts', [
            'texte' => 'test',
            'sujet' => '/api/sujets/1',
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }
}
