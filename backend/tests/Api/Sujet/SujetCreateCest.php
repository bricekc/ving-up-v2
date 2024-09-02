<?php

namespace App\Tests\Api\Sujet;

use App\Entity\Sujet;
use App\Factory\FournisseurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class SujetCreateCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'intituleSujet' => 'string',
            'posts' => 'array',
        ];
    }

    public function anonymousUserForbiddenCannotCreateSujet(ApiTester $I)
    {
        $I->sendPost('/api/sujets', [
            'intituleSujet' => 'Sujet 1',
        ]);
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserCanCreateSujet(ApiTester $I)
    {
        $user = FournisseurFactory::createOne()->object();
        $I->amLoggedInAs($user);
        $I->sendPost('/api/sujets', [
            'intituleSujet' => 'Sujet 1',
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsAnEntity(Sujet::class, '/api/sujets/1');
    }
}
