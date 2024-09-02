<?php

namespace App\Tests\Api\Post;

use App\Entity\Post;
use App\Factory\PostFactory;
use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class PostGetCest
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

    public function getPostDetail(ApiTester $I): void
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $I->sendGet('/api/posts/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsAnEntity(Post::class, '/api/posts/1');
        $I->seeResponseContainsJson([
            'texte' => $post->getTexte(),
            'date' => $post->getDate()->format('Y-m-d\TH:i:sP'),
            'sujet' => '/api/sujets/'.$post->getSujet()->getId(),
        ]);
    }

    public function getCollectionPostDetail(ApiTester $I): void
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $post2 = PostFactory::createOne();
        $I->sendGet('/api/posts');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson([
            'hydra:member' => [
                [
                    'texte' => $post->getTexte(),
                    'date' => $post->getDate()->format('Y-m-d\TH:i:sP'),
                    'sujet' => '/api/sujets/'.$post->getSujet()->getId(),
                ],
                [
                    'texte' => $post2->getTexte(),
                    'date' => $post2->getDate()->format('Y-m-d\TH:i:sP'),
                    'sujet' => '/api/sujets/'.$post2->getSujet()->getId(),
                ],
            ],
        ]);
    }
}
