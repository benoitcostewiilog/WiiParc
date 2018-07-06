<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AffectationsRepository")
 * @UniqueEntity(fields="nparc", message="Un parc existe déjà avec ce numéro.")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Parc", inversedBy="affectations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $parc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Societe", inversedBy="affectations", cascade={"persist"})
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

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $nparc;

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

    public function getNparc(): ?string
    {
        return $this->nparc;
    }

    public function setNparc(string $nparc): self
    {
        $this->nparc = $nparc;

        return $this;
    }
}
