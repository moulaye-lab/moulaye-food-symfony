<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=Contact::class)

 * @ORM\HasLifecycleCallbacks
 * 
 */
class Contact
{

 /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


     /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;


     /**
     * @ORM\Column(type="int", length=255)
     */
    private $number;


     /**
     * @ORM\Column(type="email", length=255)
     */
    private $email;

     /**
     * @ORM\Column(type="text", length=255)
     */
    private $message;


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

}
