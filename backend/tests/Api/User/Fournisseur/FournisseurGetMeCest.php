<?php

namespace App\Tests\Api\User\Fournisseur;

use App\Entity\Fournisseur;
use App\Factory\FournisseurFactory;
use App\Tests\Support\ApiTester;

class FournisseurGetMeCest
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
            'nbPost' => 'integer',
        ];
    }

    public function authenticatedFournisseurOnMeGetData(ApiTester $I): void
    {
        $user = FournisseurFactory::createOne()->object();
        FournisseurFactory::createOne();
        $I->amLoggedInAs($user);

        $I->sendGet('/api/me');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Fournisseur::class, '/api/fournisseurs/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), ['email' => $user->getEmail()]);
    }
}