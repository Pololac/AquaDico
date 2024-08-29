<?php

namespace App\Entity;

use App\Repository\OriginRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OriginRepository::class)]
class Origin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $continent = null;

    /**
     * @var Collection<int, Fish>
     */
    #[ORM\OneToMany(targetEntity: Fish::class, mappedBy: 'origin')]
    private Collection $fishes;

    public function __construct()
    {
        $this->fishes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(string $continent): static
    {
        $this->continent = $continent;

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
            $fish->setOrigin($this);
        }

        return $this;
    }

    public function removeFish(Fish $fish): static
    {
        if ($this->fishes->removeElement($fish)) {
            // set the owning side to null (unless already changed)
            if ($fish->getOrigin() === $this) {
                $fish->setOrigin(null);
            }
        }

        return $this;
    }
}
