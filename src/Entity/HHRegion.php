<?php

namespace App\Entity;

use App\Repository\HHRegionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HHRegionRepository::class)]
class HHRegion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hhId = null;

    /**
     * @param string|null $name
     * @param string|null $hhId
     */
    public function __construct(?string $name, ?string $hhId)
    {
        $this->name = $name;
        $this->hhId = $hhId;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHhId(): ?string
    {
        return $this->hhId;
    }

    public function setHhId(?string $hhId): static
    {
        $this->hhId = $hhId;

        return $this;
    }


}
