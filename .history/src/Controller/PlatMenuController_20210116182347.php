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
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}/menu", name="plats_menu")
     */
    public function index(Request $request, Restaurants $restaurant, PlatMenuRepository $repo, CategoriesMenu $categorie,CategoriesMenuRepository $categorieMenu): Response
    {


        if ($restaurant->getProprietaire() != $this->getUser() | $this->getUser()==null |$categorie->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }
            
           $plats=$repo->findByCatAndResto($categorie);
        
      
               
        return $this->render('plat_menu/plats_menu.html.twig', [
            'plats' => $plats,
            'categorie' =>$categorie,
            'restaurant'=>$restaurant
        ]);
    }


     /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}/create", name="add_plat_menu")
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
            $plats->setActived('1');
            $em->persist($plats);
            $em->flush();

            $this->addFlash('success', "Votre plat à bien été ajouter");
            
           }

    
               
        return $this->render('plat_menu/add.html.twig', [
            'AddPlatForm' => $form->createView(),
            'categorie' => $categorie
        ]);
    }


         /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}/edit", name="edit_plat_menu")
     */
    public function editPlat(EntityManagerInterface $em,Request $request,PlatMenu $plats, Restaurants $restaurant, PlatMenuRepository $repo, CategoriesMenu $categorie,CategoriesMenuRepository $categorieMenu): Response
    {


        if ($restaurant->getProprietaire() != $this->getUser() | $this->getUser()==null |$categorie->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }
           
           $form=$this->createForm(AddPlatMenuType::class,$plats);

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) {
            
            $plats->setCategorie($categorie);
            $em->persist($plats);
            $em->flush();

            $this->addFlash('success', "Votre plat à bien été ajouter");
            
           }

    
               
        return $this->render('plat_menu/edit.html.twig', [
            'AddPlatForm' => $form->createView(),
            'categorie' => $categorie
        ]);
    }


    
         /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}/actived", name="actived_plat_menu")
     */
    public function StandBy(EntityManagerInterface $em,Request $request,PlatMenu $plats, Restaurants $restaurant, PlatMenuRepository $repo, CategoriesMenu $categorie,CategoriesMenuRepository $categorieMenu): Response
    {


        if ($restaurant->getProprietaire() != $this->getUser() | $this->getUser()==null |$categorie->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }
           dd($plats);
            if ($plats->getActived()=="0") {
             $actived=   $plats->setActived('1');
             $em->persist($actived);
             $em->flush();
             $this->addFlash('success','Le plat est bien activé');
            }elseif($plats->getActived()!=="1"){
                $actived=   $plats->setActived('0');
                $em->persist($actived);
                $em->flush();
                $this->addFlash('success','Le plat est bien désactivé');

            }

        

               
            return $this->redirectToRoute('plats_menu',[
                'restaurant' => $restaurant->getId(),
                'categorie' => $categorie->getId()
            ]);   
    }

    
}
