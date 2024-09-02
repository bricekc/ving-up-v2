<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetAvatarController extends AbstractController
{
    public function __invoke(User $data): Response
    {
        if ('string' != gettype($data->getPhotoProfil())) {
            $dataPP = stream_get_contents($data->getPhotoProfil(), -1, 0);
        } else {
            $dataPP = $data->getPhotoProfil();
        }

        return new Response(
            $dataPP,
            Response::HTTP_OK,
            ['content-type' => 'image/jpeg']
        );
    }
}
