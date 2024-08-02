<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['partial_truck', 'main_truck', 'main_category'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique:true)]
    #[Groups(['partial_truck', 'main_truck', 'main_category'])]
    #[Assert\NotBlank()]
    private ?string $name = null;

    /**
     * @var Collection<int, Truck>
     */
    #[ORM\ManyToMany(targetEntity: Truck::class, mappedBy: 'category')]
    #[Groups(['main_category'])]
    private Collection $trucks;

    public function __construct()
    {
        $this->trucks = new ArrayCollection();
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
     * @return Collection<int, Truck>
     */
    public function getTrucks(): Collection
    {
        return $this->trucks;
    }

    public function addTruck(Truck $truck): static
    {
        if (!$this->trucks->contains($truck)) {
            $this->trucks->add($truck);
            $truck->addCategory($this);
        }

        return $this;
    }

    public function removeTruck(Truck $truck): static
    {
        if ($this->trucks->removeElement($truck)) {
            $truck->removeCategory($this);
        }

        return $this;
    }
}
