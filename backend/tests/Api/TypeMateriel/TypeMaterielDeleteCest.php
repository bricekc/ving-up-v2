<?php

namespace App\Tests\Api\TypeMateriel;

use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\TypeMaterielFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class TypeMaterielDeleteCest
{
    public function anonymousUserCantDeleteTypeMateriel(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $TypeMateriel = TypeMaterielFactory::createOne([
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'fournisseurs' => [$fournisseur],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->sendDelete('/api/type_materiels/'.$TypeMateriel->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function otherAuthenticatedFournisseurCantDeleteTypeMateriel(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur1 = FournisseurFactory::createOne();
        $fournisseur2 = FournisseurFactory::createOne();
        $TypeMateriel = TypeMaterielFactory::createOne([
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'fournisseurs' => [$fournisseur1],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->amLoggedInAs($fournisseur2->object());
        $I->sendDelete('/api/type_materiels/'.$TypeMateriel->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedViticulteurCantDeleteTypeMateriel(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $viticulteur = ViticulteurFactory::createOne();
        $TypeMateriel = TypeMaterielFactory::createOne([
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'fournisseurs' => [$fournisseur],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->amLoggedInAs($viticulteur->object());
        $I->sendDelete('/api/type_materiels/'.$TypeMateriel->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedAdminCanDeleteTypeMateriel(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $admin = AdminFactory::createOne();
        $TypeMateriel = TypeMaterielFactory::createOne([
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'fournisseurs' => [$fournisseur],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->amLoggedInAs($admin->object());
        $I->sendDelete('/api/type_materiels/'.$TypeMateriel->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    public function authenticatedFournisseurCanDeleteTypeMateriel(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $TypeMateriel = TypeMaterielFactory::createOne([
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'fournisseurs' => [$fournisseur],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->amLoggedInAs($fournisseur->object());
        $I->sendDelete('/api/type_materiels/'.$TypeMateriel->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
