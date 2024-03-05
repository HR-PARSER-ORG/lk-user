<?php

namespace App\Controller;

use App\Repository\AnalyticsRequestRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LayoutController extends AbstractController
{
    #[Route('/', name: 'documents')]
    public function homePage(Request $request, AnalyticsRequestRepository $requestRepository, PaginatorInterface $paginator): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $documentsQuery = $requestRepository->createQueryBuilder('r')
            ->getQuery();

        $pagination = $paginator->paginate(
            $documentsQuery,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render(
            'layout/documents.html.twig', [
                'documents' => $pagination
            ]
        );
    }

    #[Route('/cron', name: 'cron')]
    public function cronPage(): Response
    {
        return $this->render('layout/cron.html.twig');
    }
}
