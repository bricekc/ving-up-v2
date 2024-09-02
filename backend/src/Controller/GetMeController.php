<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetMeController extends AbstractController
{
    public function __invoke(): User
    {
        $user = $this->getUser();

        return $user ?? throw new $this->createNotFoundException("Vous n'êtes pas connecté");
    }
}
