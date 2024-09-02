<?php

namespace App\Tests\Api\TypeMateriel;

use App\Entity\TypeMateriel;
use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\TypeMaterielFactory;
use App\Tests\Support\ApiTester;

class TypeMaterielGetCest
{
    public function getTypeMaterielDetail(ApiTester $I): void
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
        $I->sendGet('/api/type_materiels/'.$TypeMateriel->getId());

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(TypeMateriel::class, '/api/type_materiels/'.$TypeMateriel->getId());
        $I->seeResponseContainsJson([
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
            'tag' => [],
        ]);
    }

    public function getTypeMaterielCollection(ApiTester $I): void
    {
        // 1. 'Arrange'
        $tag = TagFactory::createOne([
            'nom' => 'tagTest',
        ]);
        $fournisseur = FournisseurFactory::createOne();
        $typeMateriels = TypeMaterielFactory::createSequence([
            ['description_materiel' => 'test1', 'intitule_materiel' => 'test1', 'tag' => $tag, 'fournisseurs' => [$fournisseur]],
            ['description_materiel' => 'test2', 'intitule_materiel' => 'test2', 'tag' => $tag, 'fournisseurs' => [$fournisseur]],
            ['description_materiel' => 'test3', 'intitule_materiel' => 'test3', 'tag' => $tag, 'fournisseurs' => [$fournisseur]],
        ]);

        // 2. 'Act'
        $I->sendGet('/api/type_materiels');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(TypeMateriel::class, '/api/type_materiels', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }
}
