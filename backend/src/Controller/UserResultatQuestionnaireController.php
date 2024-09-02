<?php

namespace App\Controller;

use App\Repository\ResultatQuestionnaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserResultatQuestionnaireController extends AbstractController
{
    #[Route('/api/resultat_questionnaires/user/{userId}', name: 'get_user_resultat', methods: ['GET'])]
    public function getUserResultat(int $userId, ResultatQuestionnaireRepository $repository): Response
    {
        $resultats = $repository->findBy(['viticulteur' => $userId]);

        if (!$resultats) {
            throw $this->createNotFoundException('Aucun ResultatQuestionnaire trouvé.');
        }

        return $this->json($resultats, Response::HTTP_OK, [], ['groups' => 'get_resultat']);
    }
}
