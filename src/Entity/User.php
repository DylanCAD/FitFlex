<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_User;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_User;

    /**
     * @ORM\Column(type="integer")
     */
    private $sexe_User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar_User;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age_User;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taille_User;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $poids_User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $level_User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objectif_User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
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
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomUser(): ?string
    {
        return $this->nom_User;
    }

    public function setNomUser(string $nom_User): self
    {
        $this->nom_User = $nom_User;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenom_User;
    }

    public function setPrenomUser(string $prenom_User): self
    {
        $this->prenom_User = $prenom_User;

        return $this;
    }

    public function getSexeUser(): ?int
    {
        return $this->sexe_User;
    }

    public function setSexeUser(int $sexe_User): self
    {
        $this->sexe_User = $sexe_User;

        return $this;
    }

    public function getAvatarUser(): ?string
    {
        return $this->avatar_User;
    }

    public function setAvatarUser(?string $avatar_User): self
    {
        $this->avatar_User = $avatar_User;

        return $this;
    }

    public function getAgeUser(): ?int
    {
        return $this->age_User;
    }

    public function setAgeUser(?int $age_User): self
    {
        $this->age_User = $age_User;

        return $this;
    }

    public function getTailleUser(): ?float
    {
        return $this->taille_User;
    }

    public function setTailleUser(?float $taille_User): self
    {
        $this->taille_User = $taille_User;

        return $this;
    }

    public function getPoidsUser(): ?float
    {
        return $this->poids_User;
    }

    public function setPoidsUser(?float $poids_User): self
    {
        $this->poids_User = $poids_User;

        return $this;
    }

    public function getLevelUser(): ?string
    {
        return $this->level_User;
    }

    public function setLevelUser(?string $level_User): self
    {
        $this->level_User = $level_User;

        return $this;
    }

    public function getObjectifUser(): ?string
    {
        return $this->objectif_User;
    }

    public function setObjectifUser(?string $objectif_User): self
    {
        $this->objectif_User = $objectif_User;

        return $this;
    }
}
