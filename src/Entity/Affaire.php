<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AffaireRepository")
 */
class Affaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $designation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Politicien", mappedBy="affaire")
     */
    private $politiciens;

    public function __construct()
    {
        $this->politiciens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getDesignation();
    }

    /**
     * @return Collection|Politicien[]
     */
    public function getPoliticiens(): Collection
    {
        return $this->politiciens;
    }

    public function addPoliticien(Politicien $politicien): self
    {
        if (!$this->politiciens->contains($politicien)) {
            $this->politiciens[] = $politicien;
            $politicien->addAffaire($this);
        }

        return $this;
    }

    public function removePoliticien(Politicien $politicien): self
    {
        if ($this->politiciens->contains($politicien)) {
            $this->politiciens->removeElement($politicien);
            $politicien->removeAffaire($this);
        }

        return $this;
    }
}
