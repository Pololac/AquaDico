<?php

namespace App\Entity;

use App\Repository\FishFamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishFamilyRepository::class)]
class FishFamily
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Fish>
     */
    #[ORM\OneToMany(targetEntity: Fish::class, mappedBy: 'family')]
    private Collection $fishes;

    public function __construct()
    {
        $this->fishes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Fish>
     */
    public function getFishes(): Collection
    {
        return $this->fishes;
    }

    public function addFish(Fish $fish): static
    {
        if (!$this->fishes->contains($fish)) {
            $this->fishes->add($fish);
            $fish->setFamily($this);
        }

        return $this;
    }

    public function removeFish(Fish $fish): static
    {
        if ($this->fishes->removeElement($fish)) {
            // set the owning side to null (unless already changed)
            if ($fish->getFamily() === $this) {
                $fish->setFamily(null);
            }
        }

        return $this;
    }
}
