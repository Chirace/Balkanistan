<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PoliticienRepository")
 */
class Politicien
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=1)
     * @Assert\Regex(pattern="/^(M|F)$/", message="M : Masculin, F : Féminin")
     */
    private $sexe;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(value = 18, message="âge requis 18 ans")
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Mairie", inversedBy="politiciens")
     */
    private $mairie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parti", inversedBy="politiciens")
     */
    private $parti;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Affaire", inversedBy="politiciens")
     */
    private $affaire;

    public function __construct()
    {
        $this->affaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getMairie(): ?Mairie
    {
        return $this->mairie;
    }

    public function setMairie(?Mairie $mairie): self
    {
        $this->mairie = $mairie;

        return $this;
    }

    public function getParti(): ?Parti
    {
        return $this->parti;
    }

    public function setParti(?Parti $parti): self
    {
        $this->parti = $parti;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getNom();
    }

    /**
     * @return Collection|Affaire[]
     */
    public function getAffaire(): Collection
    {
        return $this->affaire;
    }

    public function addAffaire(Affaire $affaire): self
    {
        if (!$this->affaire->contains($affaire)) {
            $this->affaire[] = $affaire;
        }

        return $this;
    }

    public function removeAffaire(Affaire $affaire): self
    {
        if ($this->affaire->contains($affaire)) {
            $this->affaire->removeElement($affaire);
        }

        return $this;
    }
}
