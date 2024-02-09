<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LayoutController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function homePage(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('layout/home.html.twig');
    }

    #[Route('/request', name: 'request')]
    public function requestPage(): Response
    {
        return $this->render('layout/request.html.twig');
    }

    #[Route('/cron', name: 'cron')]
    public function cronPage(): Response
    {
        return $this->render('layout/cron.html.twig');
    }
}
