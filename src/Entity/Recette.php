<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

 /**
 * @ORM\Entity(repositoryClass=RecetteRepository::class)
 * @UniqueEntity(
 *      fields={"nomRecette"},
 *      message="Le nom de la recette est déjà utilisée."
 * )
 */
class Recette
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom de la recette est obligatoire.")
     */
    private $nomRecette;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageRecette;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $personneRecette;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $preparationRecette;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuissonRecette;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ingredientRecette;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $preparationdureeRecette;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeRecette;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNomRecette(): ?string
    {
        return $this->nomRecette;
    }

    public function setNomRecette(string $nomRecette): self
    {
        $this->nomRecette = $nomRecette;

        return $this;
    }

    public function getImageRecette(): ?string
    {
        return $this->imageRecette;
    }

    public function setImageRecette(?string $imageRecette): self
    {
        $this->imageRecette = $imageRecette;

        return $this;
    }

    public function getPersonneRecette(): ?string
    {
        return $this->personneRecette;
    }

    public function setPersonneRecette(?string $personneRecette): self
    {
        $this->personneRecette = $personneRecette;

        return $this;
    }

    public function getPreparationRecette(): ?string
    {
        return $this->preparationRecette;
    }

    public function setPreparationRecette(?string $preparationRecette): self
    {
        $this->preparationRecette = $preparationRecette;

        return $this;
    }

    public function getCuissonRecette(): ?string
    {
        return $this->cuissonRecette;
    }

    public function setCuissonRecette(?string $cuissonRecette): self
    {
        $this->cuissonRecette = $cuissonRecette;

        return $this;
    }

    public function getIngredientRecette(): ?string
    {
        return $this->ingredientRecette;
    }

    public function setIngredientRecette(?string $ingredientRecette): self
    {
        $this->ingredientRecette = $ingredientRecette;

        return $this;
    }

    public function getPreparationdureeRecette(): ?string
    {
        return $this->preparationdureeRecette;
    }

    public function setPreparationdureeRecette(?string $preparationdureeRecette): self
    {
        $this->preparationdureeRecette = $preparationdureeRecette;

        return $this;
    }

    public function getTypeRecette(): ?string
    {
        return $this->typeRecette;
    }

    public function setTypeRecette(?string $typeRecette): self
    {
        $this->typeRecette = $typeRecette;

        return $this;
    }
}
