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
    public function Redirection( $entity,$entity2, string $route)
    {
        if ($entity->getProprietaire() != $this->getUser() | $this->getUser()==null |$entity2->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute($route);
        }
    }

   
    /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}", name="app_plat_menu")
     */
    public function index(Request $request, Restaurants $restaurant, PlatMenuRepository $repo, CategoriesMenu $categorie,CategoriesMenuRepository $categorieMenu): Response
    {


        if ($restaurant->getProprietaire() != $this->getUser() | $this->getUser()==null |$categorie->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }
            
           $plats=$repo->findByCatAndResto($categorie);
        
      
               
        return $this->render('plat_menu/index.html.twig', [
            'plats' => $plats,
            'categorie' =>$categorie,
            'restaurant'=>$restaurant
        ]);
    }

    public function createPlat(Request $request, Restaurants $restaurant, PlatMenuRepository $repo, CategoriesMenu $categorie,CategoriesMenuRepository $categorieMenu): Response
    {


        if ($restaurant->getProprietaire() != $this->getUser() | $this->getUser()==null |$categorie->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }
           $plats=new PlatMenu;
           $form=$this->createForm(AddPlatMenuType::class,$plats);

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) {
               
            
           }

    
               
        return $this->render('plat_menu/index.html.twig', [
            'plats' => $plats,
            'categorie' =>$categorie,
            'restaurant'=>$restaurant
        ]);
    }

    
}
