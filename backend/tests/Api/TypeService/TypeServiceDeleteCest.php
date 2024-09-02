<?php

namespace App\Tests\Api\TypeService;

use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\TypeServiceFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class TypeServiceDeleteCest
{
    public function anonymousUserCantDeleteTypeService(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $TypeService = TypeServiceFactory::createOne([
            'description_service' => 'test',
            'intitule_service' => 'test',
            'fournisseurs' => [$fournisseur],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->sendDelete('/api/type_services/'.$TypeService->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function otherAuthenticatedFournisseurCantDeleteTypeService(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur1 = FournisseurFactory::createOne();
        $fournisseur2 = FournisseurFactory::createOne();
        $TypeService = TypeServiceFactory::createOne([
            'description_service' => 'test',
            'intitule_service' => 'test',
            'fournisseurs' => [$fournisseur1],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->amLoggedInAs($fournisseur2->object());
        $I->sendDelete('/api/type_services/'.$TypeService->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedViticulteurCantDeleteTypeService(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $viticulteur = ViticulteurFactory::createOne();
        $TypeService = TypeServiceFactory::createOne([
            'description_service' => 'test',
            'intitule_service' => 'test',
            'fournisseurs' => [$fournisseur],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->amLoggedInAs($viticulteur->object());
        $I->sendDelete('/api/type_services/'.$TypeService->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedAdminCanDeleteTypeService(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $admin = AdminFactory::createOne();
        $TypeService = TypeServiceFactory::createOne([
            'description_service' => 'test',
            'intitule_service' => 'test',
            'fournisseurs' => [$fournisseur],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->amLoggedInAs($admin->object());
        $I->sendDelete('/api/type_services/'.$TypeService->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    public function authenticatedFournisseurCanDeleteTypeService(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $TypeService = TypeServiceFactory::createOne([
            'description_service' => 'test',
            'intitule_service' => 'test',
            'fournisseurs' => [$fournisseur],
            'tag' => $tag,
        ]);

        // 2. 'Act'
        $I->amLoggedInAs($fournisseur->object());
        $I->sendDelete('/api/type_services/'.$TypeService->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
