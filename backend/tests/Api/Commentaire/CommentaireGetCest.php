<?php

namespace App\Tests\Api\Commentaire;

use App\Entity\Commentaire;
use App\Factory\CommentaireFactory;
use App\Factory\QuestionnaireFactory;
use App\Factory\ReponseFactory;
use App\Factory\ThematiqueFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class CommentaireGetCest
{
    public static function expectedProperties(): array
    {
        return [
            'commentaire' => 'string',
            'questionnaire' => 'string',
            'reponse' => 'string',
            'notes' => 'array',
            'thematique' => 'string',
        ];
    }

    public function getCommentaireDetail(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne();
        $thematique = ThematiqueFactory::createOne();
        $reponse = ReponseFactory::createOne();
        $commentaire = CommentaireFactory::createOne([
            'questionnaire' => $questionnaire,
            'reponse' => $reponse,
            'thematique' => $thematique,
        ]);

        $I->sendGet('/api/commentaires/'.$commentaire->getId());
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsAnItem(self::expectedProperties(), [
            'commentaire' => $commentaire->getCommentaire(),
        ]);
    }

    public function getCommentaireCollection(ApiTester $I): void
    {
        $questionnaire = QuestionnaireFactory::createOne();
        $thematique = ThematiqueFactory::createOne();

        $commentaires = [];
        for ($i = 0; $i < 3; ++$i) {
            $reponse = ReponseFactory::createOne();
            $commentaires[] = CommentaireFactory::createOne([
                'questionnaire' => $questionnaire,
                'reponse' => $reponse,
                'thematique' => $thematique,
            ]);
        }

        $I->sendGet('/api/commentaires');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Commentaire::class, '/api/commentaires', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $jsonResponse = $I->grabJsonResponse();
        $I->assertSame(3, $jsonResponse['hydra:totalItems']);
        $I->assertCount(3, $jsonResponse['hydra:member']);
    }
}
