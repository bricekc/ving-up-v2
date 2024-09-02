<?php

namespace App\Tests\Api\User;

use App\Entity\Admin;
use App\Entity\Fournisseur;
use App\Factory\AdminFactory;
use App\Factory\FournisseurFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;

class UserGetCest
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

    public function anonymousUserGetSimpleUserElement(ApiTester $I): void
    {
        $data = [
            'email' => 'four@example.com',
            'firstname' => 'firstname1',
            'lastname' => 'lastname1',
        ];
        FournisseurFactory::createOne($data);

        $I->sendGet('/api/users/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Fournisseur::class, '/api/fournisseurs/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);

        $data2 = [
            'email' => 'admin@example.com',
            'firstname' => 'firstname2',
            'lastname' => 'lastname2',
        ];
        AdminFactory::createOne($data2);

        $I->sendGet('/api/users/2');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Admin::class, '/api/admins/2');
        $I->seeResponseIsAnItem(self::expectedProperties(), $data2);
    }

    public function authenticatedUserGetSimpleUserElementForOthers(ApiTester $I): void
    {
        $user = ViticulteurFactory::createOne();
        $I->amLoggedInAs($user->object());

        $data = [
            'email' => 'four@example.com',
            'firstname' => 'firstname1',
            'lastname' => 'lastname1',
        ];
        FournisseurFactory::createOne($data);

        $I->sendGet('/api/users/2');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Fournisseur::class, '/api/fournisseurs/2');
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);

        $data2 = [
            'email' => 'admin@example.com',
            'firstname' => 'firstname2',
            'lastname' => 'lastname2',
        ];
        AdminFactory::createOne($data2);

        $I->sendGet('/api/users/3');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Admin::class, '/api/admins/3');
        $I->seeResponseIsAnItem(self::expectedProperties(), $data2);
    }
}