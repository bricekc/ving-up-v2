<?php

namespace App\Tests\Api\Tag;

use App\Entity\Tag;
use App\Factory\TagFactory;
use App\Tests\Support\ApiTester;

class TagGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'nom' => 'string',
            'typeMateriels' => 'array',
            'typeServices' => 'array',
        ];
    }

    public function getTagDetail(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'outils',
            'typeMateriels' => [],
            'typeServices' => [],
        ]);

        // 2. 'Act'
        $I->sendGet('/api/tags/'.$tag->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Tag::class, '/api/tags/'.$tag->getId());
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'nom' => 'outils',
            'typeMateriels' => [],
            'typeServices' => [],
        ]);
    }

    public function getTagCollection(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createMany(10);

        // 2. 'Act'
        $I->sendGet('/api/tags');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Tag::class, '/api/tags', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(10, $jsonResponse['hydra:totalItems']);
        $I->assertCount(10, $jsonResponse['hydra:member']);
    }
}
