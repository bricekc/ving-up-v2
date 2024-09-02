<?php

namespace App\Tests\Api\TypeMateriel;

use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class TypeMaterielCreateCest
{
    public function anonymeCantCreateTypeMateriel(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne(['nom' => 'test']);
        $fournisseur = FournisseurFactory::createOne();

        // 2. 'Act'
        $I->sendPost('/api/type_materiels', [
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'fournisseurs' => '/api/fournisseurs/'.$fournisseur->getId(),
            'tag' => '/api/tags/'.$tag->getId(),
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function adminCanCreateTypeMateriel(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne(['nom' => 'test']);
        $admin = AdminFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($admin->object());
        $I->sendPost('/api/type_materiels', [
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'tag' => '/api/tags/'.$tag->getId(),
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseContainsJson([
            'id' => 1,
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'tag' => [],
        ]);
    }

    public function fournisseurCanCreateTypeMateriel(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne(['nom' => 'test']);
        $fournisseur = FournisseurFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($fournisseur->object());
        $I->sendPost('/api/type_materiels', [
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'tag' => '/api/tags/'.$tag->getId(),
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseContainsJson([
            'id' => 1,
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'tag' => [],
        ]);
    }

    public function viticulteurCantCreateTypeMateriel(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne(['nom' => 'test']);
        $viticulteur = ViticulteurFactory::createOne();

        // 2. 'Act'
        $I->amLoggedInAs($viticulteur->object());
        $I->sendPost('/api/type_materiels', [
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'tag' => '/api/tags/'.$tag->getId(),
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
