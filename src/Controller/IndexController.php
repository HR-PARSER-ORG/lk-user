<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    #[Route('/', name: 'index')]
    public function number(): Response
    {

        return new JsonResponse(
            'indexPage'
        );
    }
}