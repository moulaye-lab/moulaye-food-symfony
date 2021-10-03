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
    public function setCodeReservation(?string $codeReservation)
    {

        $this->codeReservation = $codeReservation;

        return $this;
    }

    /**
     * getcodeReservation
     *
     * @return string
     */
    public function getCodeReservation() :?string
    {
        return $this->codeReservation;

    }


    

    

} 
 
 
 
 
 
 
 
 
 ?>