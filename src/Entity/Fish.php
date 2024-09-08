<?php

namespace App\Entity;

use App\Repository\FishRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishRepository::class)]
class Fish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latinName = null;
    
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $adultSize = null;

    #[ORM\Column(nullable: true)]
    private ?int $minTemp = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxTemp = null;

    
    #[ORM\Column(nullable: true)]
    private ?float $minPh = null;

    #[ORM\Column(nullable: true)]
    private ?float $maxPh = null;

    #[ORM\Column(nullable: true)]
    private ?int $minGh = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxGh = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picFilename = null;

    #[ORM\ManyToOne(inversedBy: 'fishes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FishFamily $family = null;

    #[ORM\ManyToOne(inversedBy: 'fishes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Origin $origin = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLatinName(): ?string
    {
        return $this->latinName;
    }

    public function setLatinName(?string $latinName): static
    {
        $this->latinName = $latinName;

        return $this;
    }

    public function getAdultSize(): ?int
    {
        return $this->adultSize;
    }

    public function setAdultSize(?int $adultSize): static
    {
        $this->adultSize = $adultSize;

        return $this;
    }

    public function getMinTemp(): ?int
    {
        return $this->minTemp;
    }

    public function setMinTemp(?int $minTemp): static
    {
        $this->minTemp = $minTemp;

        return $this;
    }

    public function getMaxTemp(): ?int
    {
        return $this->maxTemp;
    }

    public function setMaxTemp(?int $maxTemp): static
    {
        $this->maxTemp = $maxTemp;

        return $this;
    }

    public function getMinPh(): ?float
    {
        return $this->minPh;
    }

    public function setMinPh(?float $minPh): static
    {
        $this->minPh = $minPh;

        return $this;
    }

    public function getMaxPh(): ?float
    {
        return $this->maxPh;
    }

    public function setMaxPh(?float $maxPh): static
    {
        $this->maxPh = $maxPh;

        return $this;
    }

    public function getMinGh(): ?int
    {
        return $this->minGh;
    }

    public function setMinGh(?int $minGh): static
    {
        $this->minGh = $minGh;

        return $this;
    }

    public function getMaxGh(): ?int
    {
        return $this->maxGh;
    }

    public function setMaxGh(?int $maxGh): static
    {
        $this->maxGh = $maxGh;

        return $this;
    }

    public function getPicFilename(): ?string
    {
        return $this->picFilename;
    }

    public function setPicFilename(string $picFilename): static
    {
        $this->picFilename = $picFilename;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getFamily(): ?FishFamily
    {
        return $this->family;
    }

    public function setFamily(?FishFamily $family): static
    {
        $this->family = $family;

        return $this;
    }

    public function getOrigin(): ?Origin
    {
        return $this->origin;
    }

    public function setOrigin(?Origin $origin): static
    {
        $this->origin = $origin;

        return $this;
    }
}
