<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Entity\CategoriesMenu;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlatMenuController extends AbstractController

{

    public function redirect(Restaurants $restaurant)
    {
        if ($restaurant->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute('app_restaurant');
        }
    }
    /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}", name="app_plat_menu")
     */
    public function index(Request $request, Restaurants $restaurant,CategoriesMenu $categorie): Response
    {

            dd($restaurant);
            dd($categorie);
               
        return $this->render('plat_menu/index.html.twig', [
            'controller_name' => 'PlatMenuController',
        ]);
    }
}
