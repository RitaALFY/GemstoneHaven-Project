<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource
(
    collectionOperations: [
        'post' => [
            'denormalization_context' => [
                'groups' => 'user:post'
            ]
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'user:items'
            ]
        ],
        'put',
    ],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:post', 'user:items'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]

    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups([ 'user:post', 'user:items', 'address:items','galeryofuser:list', 'nft:items'])]
//    #[Assert\NotBlank(message: 'veuillez entrer le prenom')]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups([ 'user:post', 'user:items','address:items','nft:items', 'galeryofuser:list'])]
//    #[Assert\NotBlank(message: 'veuillez entrer le nom')]
    private ?string $lastName = null;

    #[ORM\Column]
    #[Groups(['user:post', 'user:items'])]
    private ?bool $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['user:post', 'user:items'])]
    private ?\DateTimeInterface $birthAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:post', 'user:items'])]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups(['user:post', 'user:items','address:post', 'address:items'])]
    private ?Address $address = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: GaleryOfUser::class)]
    #[Groups(['user:post', 'user:items', ])]
    private Collection $galeryOfUsers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Intervention::class)]
    private Collection $interventions;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Operation::class)]
    private Collection $operations;

    public function __construct()
    {
        $this->galeryOfUsers = new ArrayCollection();
        $this->interventions = new ArrayCollection();
        $this->operations = new ArrayCollection();
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthAt(): ?\DateTimeInterface
    {
        return $this->birthAt;
    }

    public function setBirthAt(\DateTimeInterface $birthAt): static
    {
        $this->birthAt = $birthAt;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, GaleryOfUser>
     */
    public function getGaleryOfUsers(): Collection
    {
        return $this->galeryOfUsers;
    }

    public function addGaleryOfUser(GaleryOfUser $galeryOfUser): static
    {
        if (!$this->galeryOfUsers->contains($galeryOfUser)) {
            $this->galeryOfUsers->add($galeryOfUser);
            $galeryOfUser->setUser($this);
        }

        return $this;
    }

    public function removeGaleryOfUser(GaleryOfUser $galeryOfUser): static
    {
        if ($this->galeryOfUsers->removeElement($galeryOfUser)) {
            // set the owning side to null (unless already changed)
            if ($galeryOfUser->getUser() === $this) {
                $galeryOfUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Intervention>
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): static
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions->add($intervention);
            $intervention->setUser($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): static
    {
        if ($this->interventions->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getUser() === $this) {
                $intervention->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): static
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
            $operation->setUser($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getUser() === $this) {
                $operation->setUser(null);
            }
        }

        return $this;
    }




}
