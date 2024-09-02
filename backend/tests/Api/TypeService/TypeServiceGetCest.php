<?php

namespace App\Tests\Api\TypeService;

use App\Entity\TypeService;
use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\TypeServiceFactory;
use App\Tests\Support\ApiTester;

class TypeServiceGetCest
{
    public function getTypeServiceDetail(ApiTester $I): void
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
        $I->sendGet('/api/type_services/'.$TypeService->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(TypeService::class, '/api/type_services/'.$TypeService->getId());
        $I->seeResponseContainsJson([
            'description_service' => 'test',
            'intitule_service' => 'test',
            'tag' => [],
        ]);
    }

    public function getTypeServiceCollection(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $typeMateriels = TypeServiceFactory::createSequence([
            ['description_service' => 'test1', 'intitule_service' => 'test1', 'tag' => $tag, 'fournisseurs' => [$fournisseur]],
            ['description_service' => 'test2', 'intitule_service' => 'test2', 'tag' => $tag, 'fournisseurs' => [$fournisseur]],
            ['description_service' => 'test3', 'intitule_service' => 'test3', 'tag' => $tag, 'fournisseurs' => [$fournisseur]],
        ]);

        // 2. 'Act'
        $I->sendGet('/api/type_services');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(TypeService::class, '/api/type_services', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }
}
