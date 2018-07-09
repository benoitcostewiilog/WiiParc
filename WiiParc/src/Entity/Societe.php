<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocieteRepository")
 */
class Societe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     #* @ORM\OneToMany(targetEntity="App\Entity\Affectations", mappedBy="societe")
     */
    #private $affectations;

        /**
     * #@ORM\ManyToMany(targetEntity="App\Entity\Utilisateurs", mappedBy="droits")
     * #@ORM\JoinColumn(nullable=false)
     */
    #private $utilisateurs;

    public function __construct()
    {
        $this->affectations = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId()
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

    /**
     #* @return Collection|Affectations[]
     */
    /*
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectations $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->setSociete($this);
        }

        return $this;
    }

    public function removeAffectation(Affectations $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getSociete() === $this) {
                $affectation->setSociete(null);
            }
        }

        return $this;
    }
    */

    /**
     #* @return Collection|Utilisateurs[]
     */
    /*
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateurs $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->addDroit($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateurs $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
            $utilisateur->removeDroit($this);
        }

        return $this;
    }
    */
}
