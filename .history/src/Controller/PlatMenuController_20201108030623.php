<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Entity\CategoriesMenu;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\RedirectionController;
class PlatMenuController extends AbstractController


{
    public function Redirection( $entity,$route)
    {
        if ($entity->getProprietaire() != $this->getUser() | $this->getUser()==null) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute($route);
        }
    }

   
    /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}", name="app_plat_menu")
     */
    public function index(Request $request, Restaurants $restaurant,CategoriesMenu $categorie): Response
    {
     $this->Redirection($restaurant,'app_home');
           
        dd($restaurant);
            dd($categorie);
               
        return $this->render('plat_menu/index.html.twig', [
            'controller_name' => 'PlatMenuController',
        ]);
    }
}
