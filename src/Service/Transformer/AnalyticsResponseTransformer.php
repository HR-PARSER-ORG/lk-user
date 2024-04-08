<?php

namespace App\Service\Transformer;

use App\DTO\AnalyticsResponseDTO;
use App\Entity\AnalyticsRequest;
use App\Repository\HHRegionRepository;
use App\Repository\HHSubIndustryRepository;

class AnalyticsResponseTransformer
{
    const EMPLOYMENT_TYPES = [
        '' => 'Не предоставлено',
        'full' => 'Полная занятость',
        'part' => 'Частичная занятость',
        'project' => 'Проектная работа',
        'volunteer' => 'Волонтерство',
        'probation' => 'Стажировка'
    ];

    const SCHEDULE_TYPES = [
        '' => 'Не предоставлено',
        'fullDay' => 'Полный день',
        'shift' => 'Сменный график',
        'flexible' => 'Гибкий график',
        'remote' => 'Удаленная работа',
        'flyInFlyOut' => 'Вахтовый метод'
    ];

    const EXPERIENCE_LEVELS = [
        '' => 'Не предоставлено',
        'noExperience' => 'Нет опыта',
        'between1And3' => 'От 1 года до 3 лет',
        'between3And6' => 'От 3 до 6 лет',
        'moreThan6' => 'Более 6 лет'
    ];

    const SEARCH_MODIFIERS = [
        '' => 'Не предоставлено',
        'name' => 'В названии вакансии',
        'company_name' => 'В названии компании',
        'description' => 'В описании вакансии'
    ];


    /**
     * @param HHRegionRepository $regionRepository
     * @param HHSubIndustryRepository $HHSubIndustryRepository
     */
    public function __construct(
        private HHRegionRepository $regionRepository,
        private HHSubIndustryRepository $HHSubIndustryRepository
    )
    {
    }

    /**
     * @param AnalyticsRequest $request
     * @return AnalyticsResponseDTO
     */
    public function analyticsRequestToDocument(AnalyticsRequest $request): AnalyticsResponseDTO
    {
        $response = new AnalyticsResponseDTO();
        $response->setId($request->getId());

        $hhRegions = $this->regionRepository->findAll();

        $searchFields = [];
        foreach ($request->getSearchModifier() ?? [] as $value) {
            $searchFields[] = $this::SEARCH_MODIFIERS[$value];
        }

        $response->setSearchModifier($searchFields);
        $response->setQualificationLevel($request->getQualificationLevel());

        $regions = [];
        foreach ($request->getRegion() ?? [] as $reqRegion) {
            foreach ($hhRegions as $hhRegion) {
                if ($hhRegion->getHhId() == $reqRegion) {
                    $regions[] = $hhRegion->getName();
                    continue 2;
                }
            }
        }

        $response->setRegion($regions);
        $response->setVmi($request->isVmi() ? 'Да' : 'Нет');
        $response->setSearchField($request->getSearchField());

        $industries = [];
        $hhIndustries = $this->HHSubIndustryRepository->findAll();
        foreach ($request->getIndustry() ?? [] as $reqIndustry) {
            foreach ($hhIndustries as $hhIndustry) {
                if ($hhIndustry->getHhId() == $reqIndustry) {
                    $industries[] = $hhIndustry->getName();
                    continue 2;
                }
            }
        }

        $response->setIndustry($industries);

        $response->setHasSalary($request->isHasSalary() ? 'Да' : 'Нет');

        $response->setEmployment($this::EMPLOYMENT_TYPES[$request->getEmployment()]);
        $response->setExperience($this::EXPERIENCE_LEVELS[$request->getExperience()]);
        $response->setSchedule($this::SCHEDULE_TYPES[$request->getSchedule()]);
        $response->setCreatedAt($request->getCreatedAtUnix());

        return $response;
    }
}