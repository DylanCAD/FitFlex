<?php

namespace App\Entity;

use App\Repository\TypeExerciceMusculationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

  /**
 * @ORM\Entity(repositoryClass=TypeExerciceMusculationRepository::class)
 * @UniqueEntity(
 *      fields={"nomTypeExerciceMusculation"},
 *      message="Le nom de l'exercice est déjà utilisé."
 * )
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
     * @Assert\NotBlank(message="Le nom de l'exercice est obligatoire.")
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
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "Vous devez sélectionner au moins un groupe musculaire.")
     */
    private $exerciceMusculations;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isFavorite;

    /**
     * @ORM\OneToMany(targetEntity=FavoriteExercise::class, mappedBy="typeExerciceMusculation")
     */
    private $favoriteExercises;

    /**
     * @ORM\OneToMany(targetEntity=Performance::class, mappedBy="exercice")
     */
    private $performances;

    public function __construct()
    {
        $this->exerciceMusculations = new ArrayCollection();
        $this->favoriteExercises = new ArrayCollection();
        $this->performances = new ArrayCollection();
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

    public function isIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(?bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }

    /**
     * @return Collection<int, FavoriteExercise>
     */
    public function getFavoriteExercises(): Collection
    {
        return $this->favoriteExercises;
    }

    public function addFavoriteExercise(FavoriteExercise $favoriteExercise): self
    {
        if (!$this->favoriteExercises->contains($favoriteExercise)) {
            $this->favoriteExercises[] = $favoriteExercise;
            $favoriteExercise->setTypeExerciceMusculation($this);
        }

        return $this;
    }

    public function removeFavoriteExercise(FavoriteExercise $favoriteExercise): self
    {
        if ($this->favoriteExercises->removeElement($favoriteExercise)) {
            // set the owning side to null (unless already changed)
            if ($favoriteExercise->getTypeExerciceMusculation() === $this) {
                $favoriteExercise->setTypeExerciceMusculation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Performance>
     */
    public function getPerformances(): Collection
    {
        return $this->performances;
    }

    public function addPerformance(Performance $performance): self
    {
        if (!$this->performances->contains($performance)) {
            $this->performances[] = $performance;
            $performance->setExercice($this);
        }

        return $this;
    }

    public function removePerformance(Performance $performance): self
    {
        if ($this->performances->removeElement($performance)) {
            // set the owning side to null (unless already changed)
            if ($performance->getExercice() === $this) {
                $performance->setExercice(null);
            }
        }

        return $this;
    }
}
