<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Entity\CategoriesMenu;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\RedirectionController;
use App\Entity\PlatMenu;
use App\Form\AddPlatMenuType;
use App\Repository\CategoriesMenuRepository;
use App\Repository\PlatMenuRepository;

class PlatMenuController extends AbstractController


{
    public function Redirection( $entity, $route)
    {
        if ($entity->getIdUser() != $this->getUser() | $this->getUser()==null) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute($route);
        }
    }

   
    /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}", name="app_plat_menu")
     */
    public function index(Request $request, Restaurants $restaurant, PlatMenuRepository $repo, CategoriesMenu $categorie,CategoriesMenuRepository $categorieMenu): Response
    {


    
            Redirec
        
      
           $plats=$repo->findByCatAndResto($categorie);
        
      
               
        return $this->render('plat_menu/index.html.twig', [
            'plat' => $plats,
            'categorie' =>$categorie,
            'restaurant'=>$restaurant
        ]);
    }


}
