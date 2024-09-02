<?php

namespace App\Tests\Api\Questionnaire;

use App\Entity\Questionnaire;
use App\Factory\AdminFactory;
use App\Factory\CommentaireFactory;
use App\Factory\FournisseurFactory;
use App\Factory\QuestionFactory;
use App\Factory\QuestionnaireFactory;
use App\Factory\ReponseFactory;
use App\Factory\ThematiqueFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class QuestionnaireGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'intitule_questionnaire' => 'string',
            'questions' => 'array',
            'public' => 'boolean',
            'thematiques' => 'array',
            'commentaires' => 'array',
        ];
    }

    public function getQuestionnaireDetail(ApiTester $I): void
    {
        $thematique = ThematiqueFactory::createOne();
        $reponse = ReponseFactory::createOne();
        $question = QuestionFactory::createOne();
        $question->addReponse($reponse->object());
        $commentaire = CommentaireFactory::createOne();
        $questionnaire = QuestionnaireFactory::createOne([
            'thematiques' => [$thematique],
            'questions' => [$question],
            'commentaires' => [$commentaire],
        ]);

        $I->sendGet('/api/questionnaires/'.$questionnaire->getId());
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson([
            'intitule_questionnaire' => $questionnaire->getIntituleQuestionnaire(),
            'questions' => [
                '@id' => '/api/questions/'.$question->getId(),
                '@type' => 'Question',
                'id' => $question->getId(),
                'intitule_question' => $question->getIntituleQuestion(),
                'reponses' => [],
            ],
        ]);
    }

    public function testAccessToNonPublicQuestionnaireAndLogout(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne(['public' => false]);
        $I->logout();
        $I->sendGet('/api/questionnaires/'.$questionnaire->getId());
        $I->seeResponseCodeIs(401);
        $I->amOnPage('/login');
    }

    public function testAccessToNonPublicQuestionnaireAndLogAsFournisseur(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne(['public' => false]);
        $fournisseur = FournisseurFactory::createOne();
        $I->amLoggedInAs($fournisseur->object());
        $I->sendGet('/api/questionnaires/'.$questionnaire->getId());
        $I->seeResponseCodeIs(403);
    }

    public function testAccessToNonPublicQuestionnaireAndLogAsAdmin(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne(['public' => false]);
        $admin = AdminFactory::createOne();
        $I->amLoggedInAs($admin->object());
        $I->sendGet('/api/questionnaires/'.$questionnaire->getId());
        $I->seeResponseCodeIs(200);
    }

    public function testAccessToNonPublicQuestionnaireAndLogAsViticulteur(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne(['public' => false]);
        $vigneron = ViticulteurFactory::createOne();
        $I->amLoggedInAs($vigneron->object());
        $I->sendGet('/api/questionnaires/'.$questionnaire->getId());
        $I->seeResponseCodeIs(200);
    }

    public function getQuestionnaireCollection(ApiTester $I): void
    {
        ThematiqueFactory::createOne();
        QuestionnaireFactory::createMany(3);

        $I->sendGet('/api/questionnaires');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Questionnaire::class, '/api/questionnaires', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }
}
