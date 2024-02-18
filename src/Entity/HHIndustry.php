<?php

namespace App\Entity;

use App\Repository\HHIndustryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HHIndustryRepository::class)]
class HHIndustry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hhId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'hhIndustry', targetEntity: HHSubIndustry::class)]
    private Collection $hHSubIndustries;

    public function __construct()
    {
        $this->hHSubIndustries = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, HHSubIndustry>
     */
    public function getHHSubIndustries(): Collection
    {
        return $this->hHSubIndustries;
    }

    public function addHHSubIndustry(HHSubIndustry $hHSubIndustry): static
    {
        if (!$this->hHSubIndustries->contains($hHSubIndustry)) {
            $this->hHSubIndustries->add($hHSubIndustry);
            $hHSubIndustry->setHhIndustry($this);
        }

        return $this;
    }

    public function removeHHSubIndustry(HHSubIndustry $hHSubIndustry): static
    {
        if ($this->hHSubIndustries->removeElement($hHSubIndustry)) {
            // set the owning side to null (unless already changed)
            if ($hHSubIndustry->getHhIndustry() === $this) {
                $hHSubIndustry->setHhIndustry(null);
            }
        }

        return $this;
    }
}
