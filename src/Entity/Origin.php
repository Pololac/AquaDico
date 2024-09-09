<?php

namespace App\Entity;

use App\Repository\OriginRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: OriginRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Origin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $continent = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Fish>
     */
    #[ORM\OneToMany(targetEntity: Fish::class, mappedBy: 'origin')]
    private Collection $fishes;

    public function __construct()
    {
        $this->fishes = new ArrayCollection();
    }

    public function __tostring() 
    {
        return $this->continent;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    // A désactiver en dév pour pouvoir générer data avec Faker
    // #[ORM\PrePersist]    
    // #[ORM\PreUpdate]
    // public function setSlugValue(SluggerInterface $slugger): void
    // {
    //     if (!$this->slug) {
    //         $this->slug = $slugger->slug($this->name)->lower();
    //     }
    // }


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
