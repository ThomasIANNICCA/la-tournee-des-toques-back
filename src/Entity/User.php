<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['main_user'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['main_user'])]
    #[Assert\NotBlank()]
    #[Assert\Email(
        message: "L' email {{ value }} n'est pas un email valide.",
    )]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['main_user'])]
    // #[Assert\NotBlank()]
    // #[Assert\Choice(['ROLE_USER', 'ROLE_TRUCKER', 'ROLE_ADMIN'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['main_user'])]
    #[Assert\NotBlank()]
    #[Assert\Regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/')]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Groups(['main_user'])]
    #[Assert\NotBlank()]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Groups(['main_user'])]
    #[Assert\NotBlank()]
    private ?string $lastname = null;

    /**
     * @var Collection<int, Truck>
     */
    #[ORM\OneToMany(targetEntity: Truck::class, mappedBy: 'user', orphanRemoval: true)]
    #[Groups(['main_user'])]
    private Collection $trucks;

    public function __construct()
    {
        $this->trucks = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

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
            $truck->setUser($this);
        }

        return $this;
    }

    public function removeTruck(Truck $truck): static
    {
        if ($this->trucks->removeElement($truck)) {
            // set the owning side to null (unless already changed)
            if ($truck->getUser() === $this) {
                $truck->setUser(null);
            }
        }

        return $this;
    }

    
}
