<?php

namespace App\DTO;

class AnalyticsResponseDTO
{
    private ?string $id = null;

    private ?string $searchField = null;

    private ?string $qualificationLevel = null;

    private ?array $region = null;

    private ?string $vmi = null;

    private ?array $searchModifier = null;

    private ?array $industry = null;

    private ?string $hasSalary = null;

    private ?string $employment = null;

    private ?string $schedule = null;

    private ?string $experience = null;

    private ?string $createdAt= null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getSearchField(): ?string
    {
        return $this->searchField;
    }

    public function setSearchField(?string $searchField): void
    {
        $this->searchField = $searchField;
    }

    public function getQualificationLevel(): ?string
    {
        return $this->qualificationLevel;
    }

    public function setQualificationLevel(?string $qualificationLevel): void
    {
        $this->qualificationLevel = $qualificationLevel;
    }

    public function getRegion(): ?array
    {
        return $this->region;
    }

    public function setRegion(?array $region): void
    {
        $this->region = $region;
    }

    public function getVmi(): ?string
    {
        return $this->vmi;
    }

    public function setVmi(?string $vmi): void
    {
        $this->vmi = $vmi;
    }

    public function getSearchModifier(): ?array
    {
        return $this->searchModifier;
    }

    public function setSearchModifier(?array $searchModifier): void
    {
        $this->searchModifier = $searchModifier;
    }

    public function getIndustry(): ?array
    {
        return $this->industry;
    }

    public function setIndustry(?array $industry): void
    {
        $this->industry = $industry;
    }

    public function getHasSalary(): ?string
    {
        return $this->hasSalary;
    }

    public function setHasSalary(?string $hasSalary): void
    {
        $this->hasSalary = $hasSalary;
    }

    public function getEmployment(): ?string
    {
        return $this->employment;
    }

    public function setEmployment(?string $employment): void
    {
        $this->employment = $employment;
    }

    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    public function setSchedule(?string $schedule): void
    {
        $this->schedule = $schedule;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): void
    {
        $this->experience = $experience;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


}