<?php

namespace App\Entity;

use App\Repository\FavoriteExerciseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavoriteExerciseRepository::class)
 */
class FavoriteExercise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favoriteExercises")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $exerciseId;

    /**
     * @ORM\ManyToOne(targetEntity=TypeExerciceMusculation::class, inversedBy="favoriteExercises")
     */
    private $typeExerciceMusculation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getExerciseId(): ?int
    {
        return $this->exerciseId;
    }

    public function setExerciseId(?int $exerciseId): self
    {
        $this->exerciseId = $exerciseId;

        return $this;
    }

    public function getTypeExerciceMusculation(): ?TypeExerciceMusculation
    {
        return $this->typeExerciceMusculation;
    }

    public function setTypeExerciceMusculation(?TypeExerciceMusculation $typeExerciceMusculation): self
    {
        $this->typeExerciceMusculation = $typeExerciceMusculation;

        return $this;
    }
}
