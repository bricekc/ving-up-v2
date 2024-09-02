<?php

namespace App\Tests\Api\User\Viticulteur;

use App\Entity\Viticulteur;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class ViticulteurPostCest
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

    public function anonymousUserCanPostViticulteur(ApiTester $I)
    {
        $data = [
            'email' => 'piodoru@example.com',
            'password' => 'test01',
            'firstname' => 'pio',
            'lastname' => 'doru',
            'cp' => '02190',
            'adresse' => 'osef',
            'ville' => 'random',
            'num_siret' => '1234567891234',
        ];

        $dataExpected = [
            'email' => 'piodoru@example.com',
            'firstname' => 'pio',
            'lastname' => 'doru',
            'cp' => '02190',
            'adresse' => 'osef',
            'ville' => 'random',
            'num_siret' => '1234567891234',
        ];

        $I->sendPost('/api/viticulteurs', $data);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseContainsJson($dataExpected);
        $I->seeResponseIsAnEntity(Viticulteur::class, '/api/viticulteurs/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataExpected);
    }

    public function authenticatedUserCannotPostFournisseur(ApiTester $I)
    {
        $user = ViticulteurFactory::createOne();
        $I->amLoggedInAs($user->object());

        $data = [
            'email' => 'piodoru@example.com',
            'password' => 'test01',
            'firstname' => 'pio',
            'lastname' => 'doru',
            'cp' => '02190',
            'adresse' => 'osef',
            'ville' => 'random',
            'nbPost' => 0,
        ];

        $I->sendPost('/api/viticulteurs', $data);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
