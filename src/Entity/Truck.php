<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: TruckRepository::class)]
#[Vich\Uploadable]
class Truck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['partial_truck', 'main_truck', 'main_user', 'main_category', 'main_dish', 'back_truck'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['partial_truck', 'main_truck', 'main_user', 'main_category', 'main_dish', 'back_truck'])]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['partial_truck', 'main_truck', 'main_user'])]    
    private ?string $pictureName = null;

    #[Vich\UploadableField(mapping: 'truck_image', fileNameProperty: 'pictureName')]
    #[Assert\Image(maxSize: '5M')]
    private ?File $pictureFile = null;

    #[ORM\Column(length: 255)]
    #[Groups(['main_truck'])]
    #[Assert\NotBlank()]
    private ?string $presentation = null;

    #[ORM\Column]
    #[Groups(['main_truck', 'main_user', 'back_truck'])]
    #[Assert\NotBlank()]
    #[Assert\Range(min: 1, max: 30)]
    private ?int $location = null;
    
    #[ORM\Column(length: 30)]
    #[Groups(['partial_truck', 'main_truck', 'main_user', 'back_truck'])]
    #[Assert\NotBlank()]
    #[Assert\Choice(['draft', 'pending', 'validated', 'refused', 'deleted'])]
    private ?string $status = null;
    
    #[ORM\Column(length: 100)]
    #[Groups(['main_truck'])]
    #[Assert\NotBlank()]
    private ?string $chef_name = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['main_truck'])]
    private ?string $chefPictureName = null;

    #[Vich\UploadableField(mapping: 'chef_image', fileNameProperty: 'chefPictureName')]
    #[Assert\Image(maxSize: '5M')]
    private ?File $chefPictureFile = null;

    #[ORM\Column(length: 255)]
    #[Groups(['main_truck'])]
    #[Assert\NotBlank()]
    private ?string $chef_description = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'trucks')]
    #[Groups(['partial_truck', 'main_truck'])]
    private Collection $category;

    /**
     * @var Collection<int, Dish>
     */
    #[ORM\OneToMany(targetEntity: Dish::class, mappedBy: 'truck', orphanRemoval: true)]
    #[Groups(['main_truck'])]
    private Collection $dish;

    #[ORM\ManyToOne(inversedBy: 'trucks')]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['main_truck'])]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


   

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->dish = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getLocation(): ?int
    {
        return $this->location;
    }

    public function setLocation(int $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getChefName(): ?string
    {
        return $this->chef_name;
    }

    public function setChefName(string $chef_name): static
    {
        $this->chef_name = $chef_name;

        return $this;
    }

    public function getChefPictureName(): ?string
    {
        return $this->chefPictureName;
    }

    public function setChefPictureName(?string $chefPictureName): static
    {
        $this->chefPictureName = $chefPictureName;

        return $this;
    }

    public function getChefDescription(): ?string
    {
        return $this->chef_description;
    }

    public function setChefDescription(string $chef_description): static
    {
        $this->chef_description = $chef_description;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Dish>
     */
    public function getDish(): Collection
    {
        return $this->dish;
    }

    public function addDish(Dish $dish): static
    {
        if (!$this->dish->contains($dish)) {
            $this->dish->add($dish);
            $dish->setTruck($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): static
    {
        if ($this->dish->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getTruck() === $this) {
                $dish->setTruck(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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
     * Get the value of chefPictureFile
     */ 
    public function getChefPictureFile()
    {
        return $this->chefPictureFile;
    }

    /**
     * Set the value of chefPictureFile
     *
     * @return  self
     */ 
    public function setChefPictureFile($chefPictureFile)
    {
        $this->chefPictureFile = $chefPictureFile;

        if (null !== $chefPictureFile) {
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
