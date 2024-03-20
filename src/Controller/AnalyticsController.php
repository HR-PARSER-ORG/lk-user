<?php

namespace App\Controller;

use App\Entity\AnalyticsRequest;
use App\Form\AnalyticsRequestType;
use App\Repository\AnalyticsRequestRepository;
use App\Repository\HHIndustryRepository;
use App\Repository\HHRegionRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
        $industriesIds = array_column($industryRepository->getIndustryHHIds(), "hhId");
        return $this->render('layout/request.html.twig', [
            'regions' => $regions,
            'industries' => $industries,
            'industriesIds' => $industriesIds,
        ]);
    }

    #[Route('/request/{uuid}', name: 'document')]
    public function documentPage(string $uuid, AnalyticsRequestRepository $analyticsRequestRepository)
    {
        $document = $analyticsRequestRepository->find(['id' => $uuid]);

        return $this->render('layout/documents/document_page.html.twig', [
           'document' => $document
        ]);
    }

    #[Route('/handle-request', name: 'handle_request', methods: ['POST'])]
    public function handleRequest(Request $request, AnalyticsRequestRepository $analyticsRequestRepository): Response
    {
        $analyticsRequest = new AnalyticsRequest();

        $analyticsRequest->setSearchField($request->get('searchField'));
        $analyticsRequest->setHasSalary($request->get('hasSalary'));
        $analyticsRequest->setVmi($request->get('hasVmi'));
        $analyticsRequest->setEmployment($request->get('employment'));
        $analyticsRequest->setSchedule($request->get('schedule'));
        $analyticsRequest->setIndustry($request->get('industry'));
        $analyticsRequest->setExperience($request->get('experience'));
        $analyticsRequest->setSearchModifier($request->get('searchModifier'));
        $analyticsRequest->setRegion($request->get('region'));
        $analyticsRequest->setCreatedAt(new \DateTime());
        $analyticsRequest->setUpdatedAt(new \DateTime());

        $analyticsRequestRepository->add($analyticsRequest);

        $form = $this->createForm(AnalyticsRequestType::class, $analyticsRequest, ['csrf_protection' => false]);
        $form->submit($request->request->all());

        if ($form->getErrors(true)->count() > 0) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }

            return new JsonResponse([
                'status' => 'false',
                'error_messages' => $errors,
            ],
            400
            );
        }

        $guzzleClient = new Client();

        $host = $this->getParameter('api_url');
        $port = $this->getParameter('api_port');

        $jsonData = array_filter([
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
        ], function($value) {
            return $value !== null;
        });

        try {
            $guzzleClient->request(
                'POST',
                sprintf('%s:%d/api/v1/analytics/create/order', $host, $port),
                [
                    'headers' => [
                        "Content-Type" => "application/json",
                    ],
                    'json' => $jsonData,
                ]
            );
            var_dump($jsonData);
        } catch (GuzzleException $e) {
            return new JsonResponse([
                'status' => 'false',
                'error_message' => $e->getMessage(),
            ]);
        }

        return new JsonResponse([
            'status' => 'success',
            'document_uuid' => $analyticsRequest->getId(),
        ]);
    }
}