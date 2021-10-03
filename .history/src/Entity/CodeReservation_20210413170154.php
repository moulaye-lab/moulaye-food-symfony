<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
class CodeReservation
{

    /**
     * codeReservation
     *
     *
     * 
     */
    private $codeReservation;


   
    /**
     * setcodeReservation
     *
     * 
     */
    public function setCodeReservation( $codeReservation) 
    {

        $this->codeReservation = $codeReservation;

        return $this;
    }

    /**
     * getcodeReservation
     *
     *
     */
    public function getCodeReservation() 
    {
        return $this->codeReservation;

    }


    

    

} 
 
 
 
 
 
 
 
 
 ?>