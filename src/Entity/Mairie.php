<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MairieRepository")
 */
class Mairie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Politicien", mappedBy="mairie")
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

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
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
            $politicien->setMairie($this);
        }

        return $this;
    }

    public function removePoliticien(Politicien $politicien): self
    {
        if ($this->politiciens->contains($politicien)) {
            $this->politiciens->removeElement($politicien);
            // set the owning side to null (unless already changed)
            if ($politicien->getMairie() === $this) {
                $politicien->setMairie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getVille();
    }
}
