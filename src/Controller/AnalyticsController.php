<?php

namespace App\Controller;

use App\Repository\HHIndustryRepository;
use App\Repository\HHRegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnalyticsController extends AbstractController
{
    #[Route('/request', name: 'request')]
    public function requestPage(HHRegionRepository $regionRepository, HHIndustryRepository $industryRepository): Response
    {
        $regions = $regionRepository->findAll();
        $industries = $industryRepository->findAll();
        return $this->render('layout/request.html.twig', [
            'regions' => $regions,
            'industries' => $industries,
        ]);
    }

    #[Route('/handle-request', name: 'handle_request', methods: ['POST'])]
    public function handleRequest(Request $request): Response
    {
        return new Response('Form submitted successfully!');
    }
}