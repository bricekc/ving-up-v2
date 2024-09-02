<?php

namespace App\Tests\Api\Tag;

use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class TagCreateCest
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

    public function anonymeCantCreateTag(ApiTester $I): void
    {
        // 1. 'Act'
        $I->sendPost('/api/tags', [
          'nom' => 'test',
        ]);

        // 2. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function AdminCanCreateTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $user = AdminFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($user->object());
        $I->sendPost('/api/tags', [
            'nom' => 'test',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseContainsJson([
            'id' => 1,
            'nom' => 'test',
            'typeMateriels' => [],
            'typeServices' => [],
        ]);
    }

    public function fournisseurCantCreateTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $user = FournisseurFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($user->object());
        $I->sendPost('/api/tags', [
            'nom' => 'test',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function viticulteurCantCreateTag(ApiTester $I): void
    {
        // 1. 'Arrange'
        $user = ViticulteurFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($user->object());
        $I->sendPost('/api/tags', [
            'nom' => 'test',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
