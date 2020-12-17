<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Entity\CategoriesMenu;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\re
class PlatMenuController extends AbstractController

{

   
    /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}", name="app_plat_menu")
     */
    public function index(Request $request, Restaurants $restaurant,CategoriesMenu $categorie): Response
    {
        rediriger($restaurant);
            
        dd($restaurant);
            dd($categorie);
               
        return $this->render('plat_menu/index.html.twig', [
            'controller_name' => 'PlatMenuController',
        ]);
    }
}
