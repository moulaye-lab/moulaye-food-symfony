<?php

namespace App\Entity;




/**
 * @ORM\Entity(repositoryClass=Contact::class)

 * 
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
     * @ORM\Column(type="string", length=255)
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getNumber(): ?int   {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

}
