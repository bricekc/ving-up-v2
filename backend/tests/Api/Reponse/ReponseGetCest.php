<?php

namespace App\Tests\Api\Reponse;

use App\Entity\Reponse;
use App\Factory\QuestionFactory;
use App\Factory\QuestionnaireFactory;
use App\Factory\ReponseFactory;
use App\Factory\ThematiqueFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class ReponseGetCest
{
    public static function expectedProperties(): array
    {
        return [
            'reponse' => 'string',
            'note' => 'integer',
            'question' => 'string',
            'commentaire' => 'object|null',
            'resultatQuestionnaire' => 'array',
        ];
    }

    public function getReponseDetail(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne();
        $thematique = ThematiqueFactory::createOne();
        $question = QuestionFactory::createOne([
            'questionnaire' => $questionnaire,
            'thematique' => $thematique,
        ]);
        $reponse = ReponseFactory::createOne(['question' => $question]);

        $I->sendGet('/api/reponses/'.$reponse->getId());
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'reponse' => $reponse->getReponse(),
        ]);
    }
    public function getReponseCollection(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne();
        $thematique = ThematiqueFactory::createOne();
        $question = QuestionFactory::createOne([
            'questionnaire' => $questionnaire,
            'thematique' => $thematique,
        ]);
        $reponses = ReponseFactory::createMany(3, ['question' => $question]);

        $I->sendGet('/api/reponses');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Reponse::class, '/api/reponses', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }
}
