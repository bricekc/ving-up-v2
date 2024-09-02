<?php

namespace App\Tests\Api\Tag;

use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class TagDeleteCest
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

    public function anonymousUserCantDeleteTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne();

        // 2. 'Act'
        $I->sendDelete('/api/tags/'.$tag->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedFournisseurCantDeleteTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne();
        $fournisseur = FournisseurFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($fournisseur->object());
        $I->sendDelete('/api/tags/'.$tag->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedViticulteurCantDeleteTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne();
        $viticulteur = ViticulteurFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($viticulteur->object());
        $I->sendDelete('/api/tags/'.$tag->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedAdminCanDeleteTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne();
        $admin = AdminFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($admin->object());
        $I->sendDelete('/api/tags/'.$tag->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
