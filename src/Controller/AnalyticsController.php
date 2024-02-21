<?php

namespace App\Controller;

use App\Entity\AnalyticsRequest;
use App\Repository\AnalyticsRequestRepository;
use App\Repository\HHIndustryRepository;
use App\Repository\HHRegionRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function handleRequest(Request $request, AnalyticsRequestRepository $analyticsRequestRepository): Response
    {
        $analyticsRequest = new AnalyticsRequest();

        $analyticsRequest->setSearchField($request->get('searchText'));
        $analyticsRequest->setHasSalary($request->get('hasSalary'));
        $analyticsRequest->setVmi($request->get('hasVmi'));
        $analyticsRequest->setEmployment($request->get('employment'));
        $analyticsRequest->setSchedule($request->get('schedule'));
        $analyticsRequest->setIndustry($request->get('industry'));
        $analyticsRequest->setExperience($request->get('experience'));
        $analyticsRequest->setSearchModifier($request->get('searchModifier'));
        $analyticsRequest->setRegion($request->get('region'));

        $analyticsRequestRepository->add($analyticsRequest);

        $guzzleClient = new Client();

        $guzzleClient->request(
            'POST',
            'http://45.90.35.14:88/api/v1/analytics/create/order',
            [
                'headers' => [
                    "Content-Type" => "application/json",
                ],
                'json' => [
                    "searchText" => $analyticsRequest->getSearchField(),
                    "timestamp" => time(),
                    "regionId" => $analyticsRequest->getRegion(),
                    "allRegion" => false,
                    "hasVmi" => false,
                    "hasSalary" => $analyticsRequest->isHasSalary(),
                    "externalId" => $analyticsRequest->getId(),
                    "employment" => $analyticsRequest->getEmployment(),
                    "experience" => $analyticsRequest->getExperience(),
                    "schedule" => $analyticsRequest->getSchedule(),
                    "industries" => $analyticsRequest->getIndustry(),
                    "vacancySearchFields" => $analyticsRequest->getSearchModifier(),
                ]
            ]
        );

        return new JsonResponse(['status' => 'success']);
    }
}