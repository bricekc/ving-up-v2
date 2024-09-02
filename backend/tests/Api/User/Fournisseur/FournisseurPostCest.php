<?php

namespace App\Tests\Api\User\Fournisseur;

use App\Entity\Fournisseur;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class FournisseurPostCest
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

    public function anonymousUserCanPostFournisseur(ApiTester $I)
    {
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

        $dataExpected = [
            'email' => 'piodoru@example.com',
            'firstname' => 'pio',
            'lastname' => 'doru',
            'cp' => '02190',
            'adresse' => 'osef',
            'ville' => 'random',
            'nbPost' => 0,
        ];

        $I->sendPost('/api/fournisseurs', $data);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseContainsJson($dataExpected);
        $I->seeResponseIsAnEntity(Fournisseur::class, '/api/fournisseurs/1');
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
        ];

        $I->sendPost('/api/fournisseurs', $data);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
