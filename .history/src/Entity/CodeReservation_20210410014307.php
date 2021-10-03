<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
class CodeReservation
{

    /**
     * codeReservation
     *
     * @Assert\NotBlank
     * 
     */
    private $codeReservation;


   
    /**
     * setcodeReservation
     *
     * 
     */
    public function setcodeReservation(?string $codeReservation)
    {
        return  $this->codeReservation ;
    }

    /**
     * getcodeReservation
     *
     * @return string
     */
    public function getcodeReservation() :?string
    {
        return $this->codeReservation;

    }


    

    

} 
 
 
 
 
 
 
 
 
 ?>