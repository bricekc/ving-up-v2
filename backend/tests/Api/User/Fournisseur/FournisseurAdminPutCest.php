<?php

namespace App\Tests\Api\User\Fournisseur;

use App\Entity\Fournisseur;
use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class FournisseurAdminPutCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'email' => 'string',
            'firstname' => 'string',
            'lastname' => 'string',
            'ville' => 'string',
            'cp' => 'string',
            'adresse' => 'string',
            'dateCreation' => 'string',
            'verif' => 'boolean',
            'nbPost' => 'integer',
        ];
    }

    public function AdminCanPutVerificationOfFournisseur(ApiTester $I)
    {
        $user = AdminFactory::createOne();
        $I->amLoggedInAs($user->object());

        $data = [
            'verif' => true,
        ];

        $four = FournisseurFactory::createOne([
            'verif' => false,
        ]);

        $dataExpected = [
            'id' => $four->getId(),
            'email' => $four->getEmail(),
            'firstname' => $four->getFirstname(),
            'lastname' => $four->getLastname(),
            'cp' => $four->getCp(),
            'adresse' => $four->getAdresse(),
            'ville' => $four->getVille(),
            'verif' => true,
            'nbPost' => 0,
        ];

        $I->sendPut('/api/fournisseur/verif/2', $data);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson($dataExpected);
        $I->seeResponseIsAnEntity(Fournisseur::class, '/api/fournisseur/verif/2');
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataExpected);
    }

    public function NonAdminUserCannotPutVerificationOfFournisseur(ApiTester $I)
    {
        $user = FournisseurFactory::createOne([
            'verif' => false,
        ]);
        $I->amLoggedInAs($user->object());

        $data = [
            'verif' => true,
        ];

        $I->sendPut('/api/fournisseur/verif/1', $data);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function anonymousUserCannotPutVerificationOfViticulteur(ApiTester $I)
    {
        $data = [
            'verif' => true,
        ];

        FournisseurFactory::createOne([
            'verif' => false,
        ]);
        $I->sendPut('/api/fournisseur/verif/1', $data);
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}