<?php

namespace App\Entity;

use App\Repository\AnalyticsRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnalyticsRequestRepository::class)]
class AnalyticsRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $searchField = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qualificationLevel = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $region = null;

    #[ORM\Column(nullable: true)]
    private ?bool $vmi = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?string $searchModifier = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $industry = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasSalary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $employment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $schedule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $experience = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSearchField(): ?string
    {
        return $this->searchField;
    }

    public function setSearchField(?string $searchField): static
    {
        $this->searchField = $searchField;

        return $this;
    }

    public function getQualificationLevel(): ?string
    {
        return $this->qualificationLevel;
    }

    public function setQualificationLevel(?string $qualificationLevel): static
    {
        $this->qualificationLevel = $qualificationLevel;

        return $this;
    }

    public function getRegion(): ?array
    {
        return $this->region;
    }

    public function setRegion(?array $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function isVmi(): ?bool
    {
        return $this->vmi;
    }

    public function setVmi(?bool $vmi): static
    {
        $this->vmi = $vmi;

        return $this;
    }

    public function getSearchModifier(): ?string
    {
        return $this->searchModifier;
    }

    public function setSearchModifier(?string $searchModifier): static
    {
        $this->searchModifier = $searchModifier;

        return $this;
    }

    public function getIndustry(): ?array
    {
        return $this->industry;
    }

    public function setIndustry(?array $industry): static
    {
        $this->industry = $industry;

        return $this;
    }

    public function isHasSalary(): ?bool
    {
        return $this->hasSalary;
    }

    public function setHasSalary(?bool $hasSalary): static
    {
        $this->hasSalary = $hasSalary;

        return $this;
    }

    public function getEmployment(): ?string
    {
        return $this->employment;
    }

    public function setEmployment(?string $employment): static
    {
        $this->employment = $employment;

        return $this;
    }

    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    public function setSchedule(?string $schedule): static
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): static
    {
        $this->experience = $experience;

        return $this;
    }
}
