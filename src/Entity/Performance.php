<?php

namespace App\Entity;

use App\Repository\PerformanceRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PerformanceRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Performance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $repetitions;

    /**
     * @ORM\ManyToOne(targetEntity=TypeExerciceMusculation::class, inversedBy="performances")
     */
    private $exercice;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="performances")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $poidsUtilise;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentairesForme;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $serie;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepetitions(): ?int
    {
        return $this->repetitions;
    }

    public function setRepetitions(?int $repetitions): self
    {
        $this->repetitions = $repetitions;

        return $this;
    }

    public function getExercice(): ?TypeExerciceMusculation
    {
        return $this->exercice;
    }

    public function setExercice(?TypeExerciceMusculation $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
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

    public function getPoidsUtilise(): ?int
    {
        return $this->poidsUtilise;
    }

    public function setPoidsUtilise(?int $poidsUtilise): self
    {
        $this->poidsUtilise = $poidsUtilise;

        return $this;
    }

    public function getCommentairesForme(): ?string
    {
        return $this->commentairesForme;
    }

    public function setCommentairesForme(?string $commentairesForme): self
    {
        $this->commentairesForme = $commentairesForme;

        return $this;
    }

    public function getSerie(): ?int
    {
        return $this->serie;
    }

    public function setSerie(?int $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     *
     * @return void
     */
    public function setAllDate():void
    {
        $this->createdAt=new \DateTimeImmutable();
        $this->updatedAt=new \DateTimeImmutable();
    }

        /**
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function changeUpdateValue():void
    {
        $this->updatedAt=new \DateTimeImmutable();
    }
}
