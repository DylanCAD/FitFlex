<?php

namespace App\Entity;

use App\Repository\ExerciceMusculationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

 /**
 * @ORM\Entity(repositoryClass=ExerciceMusculationRepository::class)
 * @UniqueEntity(
 *      fields={"nomExerciceMusculation"},
 *      message="Le nom du groupe musculaire est déjà utilisé."
 * )
 */
class ExerciceMusculation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom du groupe musculaire est obligatoire.")
     */
    private $nomExerciceMusculation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageExerciceMusculation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombreExerciceMusculation;

    /**
     * @ORM\ManyToMany(targetEntity=TypeExerciceMusculation::class, inversedBy="exerciceMusculations")
     */
    private $exercices;

    public function __construct()
    {
        $this->exercices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNomExerciceMusculation(): ?string
    {
        return $this->nomExerciceMusculation;
    }

    public function setNomExerciceMusculation(string $nomExerciceMusculation): self
    {
        $this->nomExerciceMusculation = $nomExerciceMusculation;

        return $this;
    }

    public function getImageExerciceMusculation(): ?string
    {
        return $this->imageExerciceMusculation;
    }

    public function setImageExerciceMusculation(?string $imageExerciceMusculation): self
    {
        $this->imageExerciceMusculation = $imageExerciceMusculation;

        return $this;
    }

    public function getNombreExerciceMusculation(): ?string
    {
        return $this->nombreExerciceMusculation;
    }

    public function setNombreExerciceMusculation(?string $nombreExerciceMusculation): self
    {
        $this->nombreExerciceMusculation = $nombreExerciceMusculation;

        return $this;
    }

    /**
     * @return Collection<int, TypeExerciceMusculation>
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(TypeExerciceMusculation $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
        }

        return $this;
    }

    public function removeExercice(TypeExerciceMusculation $exercice): self
    {
        $this->exercices->removeElement($exercice);

        return $this;
    }
}
