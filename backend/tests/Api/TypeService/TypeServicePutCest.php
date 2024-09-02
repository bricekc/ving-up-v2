<?php

namespace App\Tests\Api\TypeService;

use App\Entity\TypeService;
use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\TypeServiceFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class TypeServicePutCest
{
    public function anonymousUserCantPutTypeService(ApiTester $I): void
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
        $I->sendPut('/api/type_services/'.$TypeService->getId(), [
            'description_service' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function otherAutenticatedFournisseurCantPutTypeService(ApiTester $I): void
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
        $I->sendPut('/api/type_services/'.$TypeService->getId(), [
            'description_service' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedViticulteurCantPutTypeService(ApiTester $I): void
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
        $I->sendPut('/api/type_services/'.$TypeService->getId(), [
            'description_service' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedAdminCanPutTypeService(ApiTester $I): void
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
        $I->sendPut('/api/type_services/'.$TypeService->getId(), [
            'description_service' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(TypeService::class, '/api/type_services/'.$TypeService->getId());
        $I->seeResponseContainsJson(['description_service' => 'coucou']);
    }

    public function authenticatedFournisseurCanPutTypeService(ApiTester $I): void
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
        $I->sendPut('/api/type_services/'.$TypeService->getId(), [
            'description_service' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(TypeService::class, '/api/type_services/'.$TypeService->getId());
        $I->seeResponseContainsJson(['description_service' => 'coucou']);
    }
}
