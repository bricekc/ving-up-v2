<?php

// api/src/Controller/CreateMediaObjectAction.php

namespace App\Controller;

use App\Entity\Rubrique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateMediaObjectAction extends AbstractController
{
    public function __invoke(Request $request): Rubrique
    {
        $uploadedFile = $request->files->get('file');
        $description = $request->request->get('description');
        $titre = $request->request->get('titre');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new Rubrique();
        $mediaObject->file = $uploadedFile;
        $mediaObject->description = $description;
        $mediaObject->titre = $titre;
        return $mediaObject;
    }
}
