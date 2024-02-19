<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipementRepository::class)
 */
class Equipement
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
    private $nomEquipement;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionEquipement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageEquipement;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $lienEquipement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
    
    public function getNomEquipement(): ?string
    {
        return $this->nomEquipement;
    }

    public function setNomEquipement(string $nomEquipement): self
    {
        $this->nomEquipement = $nomEquipement;

        return $this;
    }

    public function getDescriptionEquipement(): ?string
    {
        return $this->descriptionEquipement;
    }

    public function setDescriptionEquipement(?string $descriptionEquipement): self
    {
        $this->descriptionEquipement = $descriptionEquipement;

        return $this;
    }

    public function getImageEquipement(): ?string
    {
        return $this->imageEquipement;
    }

    public function setImageEquipement(?string $imageEquipement): self
    {
        $this->imageEquipement = $imageEquipement;

        return $this;
    }

    public function getLienEquipement(): ?string
    {
        return $this->lienEquipement;
    }

    public function setLienEquipement(?string $lienEquipement): self
    {
        $this->lienEquipement = $lienEquipement;

        return $this;
    }
}
