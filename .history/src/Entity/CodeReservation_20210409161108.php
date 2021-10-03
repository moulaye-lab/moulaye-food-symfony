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
    public function setcodeReservation(?int $codeReservation)
    {
    $this->codeReservation =$codeReservation;
    return $this;
    }

    /**
     * getcodeReservation
     *
     * @return int
     */
    public function getcodeReservation() :?int
    {
        return $this->codeReservation;

    }


    

    

} 
 
 
 
 
 
 
 
 
 ?>