<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
class Ctables
{

    /**
     * nombreTales
     *
     * @var int|null
     */
    private $nombresTables;


   
    /**
     * setnombresTables
     *
     * 
     */
    public function setnombresTables(?int $nombresTables)
    {
    $this->nombresTables =$nombresTables;
    return $this;
    }

    /**
     * getnombresTables
     *
     * @return int
     */
    public function getnombresTables() :?int
    {
        return $this->nombresTables;

    }


    

    

} 
 
 
 
 
 
 
 
 
 ?>