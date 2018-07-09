<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateursRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 * 
 */
class Utilisateurs implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
    * @ORM\Column(type="string", length=25, unique=true)
    * @Assert\NotBlank()
    */
    private $username;

    /**
    * @ORM\Column(type="string", length=64)
    */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=4096)
     * @Assert\Regex(pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/", message="Use 1 upper case letter, 1 lower case letter, and 1 number")
     */
    private $plainPassword;

    /**
    * @ORM\Column(type="string", length=255, unique=true)
    * @Assert\NotBlank()
    * @Assert\Email()
    */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Societe", inversedBy="utilisateurs")
     * @ORM\JoinTable(name="utilisateurs_societes",
            joinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")},
            inverseJoinColumns={@ORM\JoinColumn(name="societe_id", referencedColumnName="id")}
        )
     */
    private $droits;

    public function __construct()
    {
        $this->roles = array('ROLE_USER');
        $this->droits = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

     public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * @return Collection|Societe[]
     */
    public function getDroits(): Collection
    {
        return $this->droits;
    }

    public function addDroit(Societe $droit): self
    {
        if (!$this->droits->contains($droit)) {
            $this->droits[] = $droit;
        }

        return $this;
    }

    public function removeDroit(Societe $droit): self
    {
        if ($this->droits->contains($droit)) {
            $this->droits->removeElement($droit);
        }

        return $this;
    }
}
