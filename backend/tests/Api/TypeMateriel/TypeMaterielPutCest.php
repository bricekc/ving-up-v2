<?php

namespace App\Tests\Api\TypeMateriel;

use App\Entity\TypeMateriel;
use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\TypeMaterielFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class TypeMaterielPutCest
{
    public function anonymousUserCantPutTypeMateriel(ApiTester $I): void
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
        $I->sendPut('/api/type_materiels/'.$TypeMateriel->getId(), [
            'description_materiel' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function otherAutenticatedFournisseurCantPutTypeMateriel(ApiTester $I): void
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
        $I->sendPut('/api/type_materiels/'.$TypeMateriel->getId(), [
            'description_materiel' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedViticulteurCantPutTypeMateriel(ApiTester $I): void
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
        $I->sendPut('/api/type_materiels/'.$TypeMateriel->getId(), [
            'description_materiel' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedAdminCanPutTypeMateriel(ApiTester $I): void
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
        $I->sendPut('/api/type_materiels/'.$TypeMateriel->getId(), [
            'description_materiel' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(TypeMateriel::class, '/api/type_materiels/'.$TypeMateriel->getId());
        $I->seeResponseContainsJson(['description_materiel' => 'coucou']);
    }

    public function authenticatedFournisseurCanPutTypeMateriel(ApiTester $I): void
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
        $I->sendPut('/api/type_materiels/'.$TypeMateriel->getId(), [
            'description_materiel' => 'coucou',
        ]);

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(TypeMateriel::class, '/api/type_materiels/'.$TypeMateriel->getId());
        $I->seeResponseContainsJson(['description_materiel' => 'coucou']);
    }
}
