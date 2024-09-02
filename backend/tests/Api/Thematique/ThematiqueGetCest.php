<?php

namespace App\Tests\Api\Thematique;

use App\Entity\Thematique;
use App\Factory\CommentaireFactory;
use App\Factory\QuestionFactory;
use App\Factory\QuestionnaireFactory;
use App\Factory\ThematiqueFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class ThematiqueGetCest
{
    public static function expectedProperties(): array
    {
        return [
            'questions' => 'array',
            'questionnaires' => 'array',
            'commentaires' => 'array',
            'NomThematique' => 'string',
        ];
    }

    public function getThematiqueDetail(ApiTester $I): void
    {
        $thematique = ThematiqueFactory::createOne();
        $question = QuestionFactory::createOne(['thematique' => $thematique]);
        $questionnaire = QuestionnaireFactory::createOne()->addThematique($thematique->object());
        $commentaire = CommentaireFactory::createOne(['thematique' => $thematique]);

        $I->sendGet('/api/thematiques/'.$thematique->getId());
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'NomThematique' => $thematique->getNomThematique(),
        ]);
    }

    public function getThematiqueCollection(ApiTester $I): void
    {
        $thematiques = ThematiqueFactory::createMany(3);
        $questions = QuestionFactory::createMany(3, fn () => ['thematique' => $thematiques[array_rand($thematiques)]]);
        $questionnaires = QuestionnaireFactory::createMany(3, fn () => ['thematiques' => [$thematiques[array_rand($thematiques)]]]);
        $commentaires = CommentaireFactory::createMany(3, fn () => ['thematique' => $thematiques[array_rand($thematiques)]]);

        $I->sendGet('/api/thematiques');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Thematique::class, '/api/thematiques', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }
}
