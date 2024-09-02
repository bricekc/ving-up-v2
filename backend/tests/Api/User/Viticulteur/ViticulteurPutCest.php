<?php

namespace App\Tests\Api\User\Viticulteur;

use App\Entity\Viticulteur;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class ViticulteurPutCest
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

    public function viticulteurCanPutHisDataAndHisPassword(ApiTester $I)
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
            'nbPost' => 0,
        ];

        $I->sendPut('/api/viticulteurs/1', $data);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson($dataExpected);
        $I->seeResponseIsAnEntity(Viticulteur::class, '/api/viticulteurs/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataExpected);

        $I->amOnPage('/logout');

        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful();
        $I->submitForm(
            'form',
            ['email' => 'piodoru@example.com', 'password' => 'test01'],
            'Sign in'
        );
        $I->seeResponseCodeIsSuccessful();
        $I->seeInCurrentUrl('/api/docs');
    }

    public function UserCannotPutAnOtherViticulteur(ApiTester $I)
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
            'num_siret' => '1234567891234',
        ];

        ViticulteurFactory::createOne();
        $I->sendPut('/api/viticulteurs/2', $data);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function anonymousUserCannotPutAViticulteur(ApiTester $I)
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

        ViticulteurFactory::createOne();
        $I->sendPut('/api/viticulteurs/1', $data);
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}