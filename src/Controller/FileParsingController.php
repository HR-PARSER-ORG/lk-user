<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FileParsingController extends AbstractController
{
    #[Route('/file/{text}', name: 'post_show')]
    public function showPost(string $text): JsonResponse
    {
        $filepath = $this->getParameter('file_storage') . 'asd.txt';
        file_put_contents($filepath, $text);
        return new JsonResponse($filepath);
    }
}