<?php

namespace App\Tests\Api\User\Viticulteur;

use App\Entity\Viticulteur;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;

class ViticulteurGetMeCest
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
            'nbPost' => 'integer',
        ];
    }

    public function authenticatedViticulteurOnMeGetData(ApiTester $I): void
    {
        $user = ViticulteurFactory::createOne()->object();
        ViticulteurFactory::createOne();
        $I->amLoggedInAs($user);

        $I->sendGet('/api/me');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Viticulteur::class, '/api/viticulteurs/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), ['email' => $user->getEmail()]);
    }
}
