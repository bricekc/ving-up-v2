<?php

namespace App\Tests\Api\Post;

use App\Factory\PostFactory;
use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class PostPatchCest
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

    public function anonymousUserCannotPatchPost(ApiTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        PostFactory::createOne();
        $I->sendPatch('/api/posts/1', [
            'texte' => 'New text',
        ]);
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserCannotPatchPost(ApiTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $user = ViticulteurFactory::createOne()->object();
        $I->amLoggedInAs($user);
        $I->sendPatch('/api/posts/1', [
            'texte' => 'New text',
        ]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedUserCanPatchIsPost(ApiTester $I)
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
        $I->sendPatch('/api/posts/'.$post2->getId(), [
            'texte' => 'New text',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
