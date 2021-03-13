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

}
