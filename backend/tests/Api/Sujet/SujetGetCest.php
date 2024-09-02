<?php

namespace App\Tests\Api\Sujet;

use App\Entity\Sujet;
use App\Factory\SujetFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class SujetGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'intitule_sujet' => 'string',
            'posts' => 'array',
            'date_last_update' => 'string',
        ];
    }

    public function getSujetDetail(ApiTester $I): void
    {
        $sujet = SujetFactory::new()->create();
        $I->sendGET('/api/sujets/'.$sujet->getId());
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Sujet::class, '/api/sujets/'.$sujet->getId());
        $I->seeResponseContainsJson([
            'intitule_sujet' => $sujet->getIntituleSujet(),
            'posts' => [],
        ]);
    }

    public function getCollectionSujetDetail(ApiTester $I): void
    {
        $sujet = SujetFactory::new()->create();
        $sujet2 = SujetFactory::new()->create();
        $I->sendGET('/api/sujets');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'hydra:member' => [
                [
                    'intitule_sujet' => $sujet->getIntituleSujet(),
                    'posts' => [],
                ],
                [
                    'intitule_sujet' => $sujet2->getIntituleSujet(),
                    'posts' => [],
                ],
            ],
        ]);
    }
}
