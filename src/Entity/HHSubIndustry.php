<?php

namespace App\Entity;

use App\Repository\HHSubIndustryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HHSubIndustryRepository::class)]
class HHSubIndustry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hhId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'hHSubIndustries')]
    private ?HHIndustry $hhIndustry = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHhId(): ?string
    {
        return $this->hhId;
    }

    public function setHhId(?string $hhId): static
    {
        $this->hhId = $hhId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getHhIndustry(): ?HHIndustry
    {
        return $this->hhIndustry;
    }

    public function setHhIndustry(?HHIndustry $hhIndustry): static
    {
        $this->hhIndustry = $hhIndustry;

        return $this;
    }
}
