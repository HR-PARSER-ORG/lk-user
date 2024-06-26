<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\AnalyticsRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity(repositoryClass: AnalyticsRequestRepository::class)]
class AnalyticsRequest
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: "uuid", unique: true)]
    private ?string $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $searchField = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $createdAtUnix;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qualificationLevel = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $region = null;

    #[ORM\Column(nullable: true)]
    private ?bool $vmi = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $searchModifier = null;

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

    public function getId(): ?string
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

    public function getSearchModifier(): ?array
    {
        return $this->searchModifier;
    }

    public function setSearchModifier(?array $searchModifier): static
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
        if ($employment == '') {
            $this->employment = null;
        } else {
            $this->employment = $employment;
        }

        return $this;
    }

    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    public function setSchedule(?string $schedule): static
    {
        if ($schedule == '') {
            $this->schedule = null;
        } else {
            $this->schedule = $schedule;
        }

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): static
    {
        if ($experience == '') {
            $this->experience = null;
        } else {
            $this->experience = $experience;
        }

        return $this;
    }

    public function getCreatedAtUnix(): ?int
    {
        return $this->createdAtUnix;
    }

    public function setCreatedAtUnix(?int $createdAtUnix): void
    {
        $this->createdAtUnix = $createdAtUnix;
    }
}
