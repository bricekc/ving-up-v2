<?php

namespace App\Tests\Api\Vigne;

use App\Factory\VigneFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class VignesPatchCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'superficie' => 'integer',
            'latitude' => 'string',
            'longitude' => 'string',
            'viticulteur' => ViticulteurFactory::random(),
        ];
    }

    public function anonymouspatchvignes(ApiTester $I): void
    {
        ViticulteurFactory::createMany(8);
        VigneFactory::createOne();
        $I->sendPatch('/api/vignes/1', ['superficie' => 200]);
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    /**
     * @throws \Exception
     */
    public function authenticateUserpatchvignes(ApiTester $I): void
    {
        ViticulteurFactory::createMany(8);
        $user = ViticulteurFactory::createOne();
        $vigne = VigneFactory::createOne([
            'superficie' => 10,
            'latitude' => '100',
            'longitude' => '100',
            'viticulteur' => $user,
        ]);

        $I->amLoggedInAs($user->object());
        $I->sendPatch('/api/vignes/1', ['superficie' => 200]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
