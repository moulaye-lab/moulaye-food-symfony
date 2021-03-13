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
     * @ORM\Column(type="string", length=255)
     */
    private $number;


     /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;





}
