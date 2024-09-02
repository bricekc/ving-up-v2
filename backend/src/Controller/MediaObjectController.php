<?php

namespace App\Controller;
use App\Entity\Rubrique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class MediaObjectController extends AbstractController
{
    #[Route('/api/rubriques/{id}/file', name: 'rubrique_file')]
    public function getFile(int $id): BinaryFileResponse
    {
        $rubrique = $this->getDoctrine()->getRepository(Rubrique::class)->find($id);
        $filePath = $rubrique->getFilePath();

        $response = new BinaryFileResponse($this->getParameter('kernel.project_dir').'/public/media/'.$filePath);

        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $rubrique->getFilePath()
        );

        return $response;
    }
}