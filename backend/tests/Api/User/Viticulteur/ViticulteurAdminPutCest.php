<?php

namespace App\Tests\Api\User\Viticulteur;

use App\Entity\Viticulteur;
use App\Factory\AdminFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class ViticulteurAdminPutCest
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
            'num_siret' => 'string',
            'verif' => 'boolean',
            'nbPost' => 'integer',
        ];
    }

    public function AdminCanPutVerificationOfViticulteur(ApiTester $I)
    {
        $user = AdminFactory::createOne();
        $I->amLoggedInAs($user->object());

        $data = [
            'verif' => true,
        ];

        $viti = ViticulteurFactory::createOne();

        $dataExpected = [
            'id' => $viti->getId(),
            'email' => $viti->getEmail(),
            'firstname' => $viti->getFirstname(),
            'lastname' => $viti->getLastname(),
            'cp' => $viti->getCp(),
            'adresse' => $viti->getAdresse(),
            'ville' => $viti->getVille(),
            'num_siret' => $viti->getNumSiret(),
            'verif' => true,
            'nbPost' => 0,
        ];

        $I->sendPut('/api/viticulteur/verif/2', $data);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson($dataExpected);
        $I->seeResponseIsAnEntity(Viticulteur::class, '/api/viticulteur/verif/2');
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataExpected);
    }

    public function NonAdminUserCannotPutVerificationOfViticulteur(ApiTester $I)
    {
        $user = ViticulteurFactory::createOne();
        $I->amLoggedInAs($user->object());

        $data = [
            'verif' => true,
        ];

        $I->sendPut('/api/viticulteur/verif/1', $data);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function anonymousUserCannotPutVerificationOfViticulteur(ApiTester $I)
    {
        $data = [
            'verif' => true,
        ];

        ViticulteurFactory::createOne();
        $I->sendPut('/api/viticulteur/verif/1', $data);
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}