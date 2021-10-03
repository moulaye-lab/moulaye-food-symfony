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
    public function setCodeReservation(?int $codeReservation) : self
    {

        $this->codeReservation = $codeReservation;

        return $this;
    }

    /**
     * getcodeReservation
     *
     * @return int
     */
    public function getCodeReservation() :?int
    {
        return $this->codeReservation;

    }


    

    

} 
 
 
 
 
 
 
 
 
 ?>