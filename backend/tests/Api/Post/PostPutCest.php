<?php

namespace App\Tests\Api\Post;

use App\Factory\PostFactory;
use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class PostPutCest
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

    public function anonymousUserCannotPutPost(ApiTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        PostFactory::createOne();
        $I->sendPUT('/api/posts/1', [
            'texte' => 'New text',
        ]);
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserCannotPutPost(ApiTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $user = ViticulteurFactory::createOne()->object();
        $I->amLoggedInAs($user);
        $I->sendPut('/api/posts/1', [
            'texte' => 'New text',
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedUserCanPutIsPost(ApiTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $user = ViticulteurFactory::createOne();
        $post2 = PostFactory::createOne([
            'sujet' => $post->getSujet(),
            'user' => $user,
            'date' => new \DateTime(),
            'texte' => 'test',
        ]);

        $I->amLoggedInAs($user->object());
        $I->sendPut('/api/posts/'.$post2->getId(), [
            'texte' => 'New text',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
