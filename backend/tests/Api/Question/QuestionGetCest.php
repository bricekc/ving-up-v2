<?php

namespace App\Tests\Api\Question;

use App\Entity\Question;
use App\Factory\QuestionFactory;
use App\Factory\QuestionnaireFactory;
use App\Factory\ReponseFactory;
use App\Factory\ThematiqueFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class QuestionGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'intitule_question' => 'string',
            'questionnaire' => 'string',
            'reponses' => 'array',
            'thematique' => 'string',
        ];
    }

    public function getQuestionDetail(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne();
        $thematique = ThematiqueFactory::createOne();
        $question = QuestionFactory::createOne([
            'questionnaire' => $questionnaire,
            'thematique' => $thematique,
        ]);
        ReponseFactory::createMany(3, ['question' => $question]);

        $I->sendGet('/api/questions/'.$question->getId());
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'intitule_question' => $question->getIntituleQuestion(),
        ]);
    }

    public function getQuestionCollection(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne();
        $thematique = ThematiqueFactory::createOne();
        $questions = QuestionFactory::createMany(3, [
            'questionnaire' => $questionnaire,
            'thematique' => $thematique,
        ]);

        foreach ($questions as $question) {
            ReponseFactory::createMany(3, ['question' => $question]);
        }

        $I->sendGet('/api/questions');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Question::class, '/api/questions', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }
}
