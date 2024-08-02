<?php

namespace App\Entity;

use App\Repository\DishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: DishRepository::class)]
#[Vich\Uploadable]
class Dish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['main_truck', 'main_dish'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['main_truck', 'main_dish'])]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['main_truck', 'main_dish'])]
    private ?string $pictureName = null;

    #[Vich\UploadableField(mapping: 'dish_image', fileNameProperty: 'pictureName')]
    #[Assert\Image(maxSize: '5M')]
    private ?File $pictureFile = null;

    #[ORM\Column(length: 255)]
    #[Groups(['main_truck', 'main_dish'])]
    #[Assert\NotBlank()]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['main_truck', 'main_dish'])]
    #[Assert\Positive]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['main_truck', 'main_dish'])]
    private ?int $menu_order = null;

    #[ORM\Column(length: 50)]
    #[Groups(['main_truck', 'main_dish'])]
    #[Assert\NotBlank()]
    private ?string $type = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'dishes')]
    #[Groups(['main_truck', 'main_dish'])]
    private Collection $tag;

    #[ORM\ManyToOne(inversedBy: 'dish')]
    #[Groups(['main_dish'])]
    private ?Truck $truck = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    public function __construct()
    {
        $this->tag = new ArrayCollection();
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

    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    public function setPictureName(?string $pictureName): static
    {
        $this->pictureName = $pictureName;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getMenuOrder(): ?int
    {
        return $this->menu_order;
    }

    public function setMenuOrder(?int $menu_order): static
    {
        $this->menu_order = $menu_order;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tag->contains($tag)) {
            $this->tag->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tag->removeElement($tag);

        return $this;
    }

    public function getTruck(): ?Truck
    {
        return $this->truck;
    }

    public function setTruck(?Truck $truck): static
    {
        $this->truck = $truck;

        return $this;
    }

    /**
     * Get the value of pictureFile
     */ 
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * Set the value of pictureFile
     *
     * @return  self
     */ 
    public function setPictureFile($pictureFile)
    {
        $this->pictureFile = $pictureFile;

        if (null !== $pictureFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
