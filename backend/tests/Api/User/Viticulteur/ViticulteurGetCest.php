<?php

namespace App\Tests\Api\User\Viticulteur;

use App\Entity\Viticulteur;
use App\Factory\FournisseurFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;

class ViticulteurGetCest
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

    public function anonymousUserGetSimpleViticulteurElement(ApiTester $I): void
    {
        $data = [
            'email' => 'viti@example.com',
            'firstname' => 'firstname1',
            'lastname' => 'lastname1',
        ];
        ViticulteurFactory::createOne($data);

        $I->sendGet('/api/users/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Viticulteur::class, '/api/viticulteurs/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);
    }

    public function authenticatedUserGetSimpleViticulteurElementForOthers(ApiTester $I): void
    {
        $data = [
            'email' => 'viti@example.com',
            'firstname' => 'firstname1',
            'lastname' => 'lastname1',
        ];
        ViticulteurFactory::createOne($data);

        $user = FournisseurFactory::createOne();
        $I->amLoggedInAs($user->object());

        $I->sendGet('/api/users/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Viticulteur::class, '/api/viticulteurs/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);
    }
}