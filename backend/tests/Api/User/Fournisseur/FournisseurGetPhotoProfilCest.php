<?php

namespace App\Tests\Api\User\Fournisseur;

use App\Factory\FournisseurFactory;
use App\Tests\Support\ApiTester;

class FournisseurGetPhotoProfilCest
{
    public function getPhotoProfilForViticulteur(ApiTester $I): void
    {
        $viti = FournisseurFactory::createOne();

        $I->sendGet('/api/users/1/avatar');

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'image/jpeg');
        $I->seeResponseContains(stream_get_contents($viti->getPhotoProfil(), -1, 0));
    }
}