<?php

namespace App\Tests\Api\Tag;

use App\Entity\Tag;
use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class TagPutCest
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

    public function anonymousUserCantPutTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne();

        // 2. 'Act'
        $I->sendPut('/api/tags/'.$tag->getId(), [
            'nom' => 'test',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedFournisseurCantPutTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne();
        $fournisseur = FournisseurFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($fournisseur->object());
        $I->sendPut('/api/tags/'.$tag->getId(), [
            'nom' => 'test',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedViticulteurCantPutTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne();
        $Viticulteur = ViticulteurFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($Viticulteur->object());
        $I->sendPut('/api/tags/'.$tag->getId(), [
            'nom' => 'test',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedAdminCanPutTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne(['nom' => 'coucou']);
        $admin = AdminFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($admin->object());
        $I->sendPut('/api/tags/'.$tag->getId(), [
            'nom' => 'test',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Tag::class, '/api/tags/'.$tag->getId());
        $I->seeResponseContainsJson(['nom' => 'test']);
    }
}
