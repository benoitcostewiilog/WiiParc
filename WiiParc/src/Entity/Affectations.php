<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AffectationsRepository")
 */
class Affectations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parc", inversedBy="affectations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Societe", inversedBy="affectations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $societe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dentree;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dsortie;

    public function getId()
    {
        return $this->id;
    }

    public function getParc(): ?Parc
    {
        return $this->parc;
    }

    public function setParc(?Parc $parc): self
    {
        $this->parc = $parc;

        return $this;
    }

    public function getSociete(): ?Societe
    {
        return $this->societe;
    }

    public function setSociete(?Societe $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getDentree(): ?\DateTimeInterface
    {
        return $this->dentree;
    }

    public function setDentree(\DateTimeInterface $dentree): self
    {
        $this->dentree = $dentree;

        return $this;
    }

    public function getDsortie(): ?\DateTimeInterface
    {
        return $this->dsortie;
    }

    public function setDsortie(?\DateTimeInterface $dsortie): self
    {
        $this->dsortie = $dsortie;

        return $this;
    }
}
