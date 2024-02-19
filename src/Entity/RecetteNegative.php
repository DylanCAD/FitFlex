<?php

namespace App\Entity;

use App\Repository\RecetteNegativeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecetteNegativeRepository::class)
 */
class RecetteNegative
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomRecetteNegative;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageRecetteNegative;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $personneRecetteNegative;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $preparationRecetteNegative;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuissonRecetteNegative;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ingredientRecetteNegative;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $preparationdureeRecetteNegative;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeRecetteNegative;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNomRecetteNegative(): ?string
    {
        return $this->nomRecetteNegative;
    }

    public function setNomRecetteNegative(string $nomRecetteNegative): self
    {
        $this->nomRecetteNegative = $nomRecetteNegative;

        return $this;
    }

    public function getImageRecetteNegative(): ?string
    {
        return $this->imageRecetteNegative;
    }

    public function setImageRecetteNegative(?string $imageRecetteNegative): self
    {
        $this->imageRecetteNegative = $imageRecetteNegative;

        return $this;
    }

    public function getPersonneRecetteNegative(): ?string
    {
        return $this->personneRecetteNegative;
    }

    public function setPersonneRecetteNegative(?string $personneRecetteNegative): self
    {
        $this->personneRecetteNegative = $personneRecetteNegative;

        return $this;
    }

    public function getPreparationRecetteNegative(): ?string
    {
        return $this->preparationRecetteNegative;
    }

    public function setPreparationRecetteNegative(?string $preparationRecetteNegative): self
    {
        $this->preparationRecetteNegative = $preparationRecetteNegative;

        return $this;
    }

    public function getCuissonRecetteNegative(): ?string
    {
        return $this->cuissonRecetteNegative;
    }

    public function setCuissonRecetteNegative(?string $cuissonRecetteNegative): self
    {
        $this->cuissonRecetteNegative = $cuissonRecetteNegative;

        return $this;
    }

    public function getIngredientRecetteNegative(): ?string
    {
        return $this->ingredientRecetteNegative;
    }

    public function setIngredientRecetteNegative(?string $ingredientRecetteNegative): self
    {
        $this->ingredientRecetteNegative = $ingredientRecetteNegative;

        return $this;
    }

    public function getPreparationdureeRecetteNegative(): ?string
    {
        return $this->preparationdureeRecetteNegative;
    }

    public function setPreparationdureeRecetteNegative(?string $preparationdureeRecetteNegative): self
    {
        $this->preparationdureeRecetteNegative = $preparationdureeRecetteNegative;

        return $this;
    }

    public function getTypeRecetteNegative(): ?string
    {
        return $this->typeRecetteNegative;
    }

    public function setTypeRecetteNegative(?string $typeRecetteNegative): self
    {
        $this->typeRecetteNegative = $typeRecetteNegative;

        return $this;
    }
}
