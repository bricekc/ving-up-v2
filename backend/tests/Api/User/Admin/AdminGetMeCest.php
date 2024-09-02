<?php

namespace App\Tests\Api\User\Admin;

use App\Entity\Admin;
use App\Factory\AdminFactory;
use App\Tests\Support\ApiTester;

class AdminGetMeCest
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
        $user = AdminFactory::createOne()->object();
        AdminFactory::createOne();
        $I->amLoggedInAs($user);

        $I->sendGet('/api/me');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Admin::class, '/api/admins/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), ['email' => $user->getEmail()]);
    }
}