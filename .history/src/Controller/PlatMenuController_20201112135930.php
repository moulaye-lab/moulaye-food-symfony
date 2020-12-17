<?php

namespace App\Controller;

use App\Entity\PlatMenu;
use App\Entity\Restaurants;
use App\Form\AddPlatMenuType;
use App\Entity\CategoriesMenu;
use App\Repository\PlatMenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\RedirectionController;
use App\Repository\CategoriesMenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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


     /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}", name="add_plat_menu")
     */
    public function createPlat(EntityManagerInterface $em,Request $request, Restaurants $restaurant, PlatMenuRepository $repo, CategoriesMenu $categorie,CategoriesMenuRepository $categorieMenu): Response
    {


        if ($restaurant->getProprietaire() != $this->getUser() | $this->getUser()==null |$categorie->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }
           $plats=new PlatMenu;
           $form=$this->createForm(AddPlatMenuType::class,$plats);

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) {
            
            $plats->setCategorie($categorie);
            $em->persist($plats);
            $em->flush();
            
           }

    
               
        return $this->render('plat_menu/index.html.twig', [
            'plats' => $plats,
            'categorie' =>$categorie,
            'restaurant'=>$restaurant
        ]);
    }

    
}