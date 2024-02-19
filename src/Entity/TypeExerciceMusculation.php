<?php

namespace App\Entity;

use App\Repository\TypeExerciceMusculationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeExerciceMusculationRepository::class)
 */
class TypeExerciceMusculation
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
    private $nomTypeExerciceMusculation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageTypeExerciceMusculation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titreTypeExerciceMusculation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionTypeExerciceMusculation;

    /**
     * @ORM\ManyToMany(targetEntity=ExerciceMusculation::class, mappedBy="exercices")
     */
    private $exerciceMusculations;

    public function __construct()
    {
        $this->exerciceMusculations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeExerciceMusculation(): ?string
    {
        return $this->nomTypeExerciceMusculation;
    }

    public function setNomTypeExerciceMusculation(string $nomTypeExerciceMusculation): self
    {
        $this->nomTypeExerciceMusculation = $nomTypeExerciceMusculation;

        return $this;
    }

    public function getImageTypeExerciceMusculation(): ?string
    {
        return $this->imageTypeExerciceMusculation;
    }

    public function setImageTypeExerciceMusculation(?string $imageTypeExerciceMusculation): self
    {
        $this->imageTypeExerciceMusculation = $imageTypeExerciceMusculation;

        return $this;
    }

    public function getTitreTypeExerciceMusculation(): ?string
    {
        return $this->titreTypeExerciceMusculation;
    }

    public function setTitreTypeExerciceMusculation(?string $titreTypeExerciceMusculation): self
    {
        $this->titreTypeExerciceMusculation = $titreTypeExerciceMusculation;

        return $this;
    }

    public function getDescriptionTypeExerciceMusculation(): ?string
    {
        return $this->descriptionTypeExerciceMusculation;
    }

    public function setDescriptionTypeExerciceMusculation(?string $descriptionTypeExerciceMusculation): self
    {
        $this->descriptionTypeExerciceMusculation = $descriptionTypeExerciceMusculation;

        return $this;
    }

    /**
     * @return Collection<int, ExerciceMusculation>
     */
    public function getExerciceMusculations(): Collection
    {
        return $this->exerciceMusculations;
    }

    public function addExerciceMusculation(ExerciceMusculation $exerciceMusculation): self
    {
        if (!$this->exerciceMusculations->contains($exerciceMusculation)) {
            $this->exerciceMusculations[] = $exerciceMusculation;
            $exerciceMusculation->addExercice($this);
        }

        return $this;
    }

    public function removeExerciceMusculation(ExerciceMusculation $exerciceMusculation): self
    {
        if ($this->exerciceMusculations->removeElement($exerciceMusculation)) {
            $exerciceMusculation->removeExercice($this);
        }

        return $this;
    }
}
