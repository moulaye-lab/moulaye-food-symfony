<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Entity\CategoriesMenu;
use App\Form\CategoriesMenuType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoriesMenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories/{id<[0-9]+>}", name="app_gestion_menu")
     */
    public function index(CategoriesMenuRepository $repo,Restaurants $restaurants): Response
    {
        if ($this->getUser()===null ) {
            $this->addFlash('error','Diantre veuillez vous connecter pour y acceder!!!!');
            return $this->redirectToRoute('app_login');  //si le user est deja connecter on le redirige vers la page d'acceuil
       }

       if ($restaurants->getProprietaire() != $this->getUser()) {
            $this->addFlash('error','Accès refusé!!!!');
            return $this->redirectToRoute('app_restaurant'); 
       }
           
            $user=$this->getUser()->getId();
            $categories= $repo->findByResto($restaurants);
            
           
        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
            'restaurant' => $restaurants,
            
        ]);
    }

    /**
     * @Route("/categories/{id<[0-9]+>}/create", name="app_create_categorie", methods={"POST","GET"})
     */
    public function CreateCategories(Restaurants $restaurant,Request $request,EntityManagerInterface $em): Response
    {   

        if ($restaurant->getProprietaire() != $this->getUser()) {
            $this->addFlash('error','Accès refusé!!!!');
            return $this->redirectToRoute('app_restaurant'); 
       }
        $user=$this->getUser();
        $categories=new CategoriesMenu;
      
        $form=$this->createForm(CategoriesMenuType::class,$categories);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $categories->setProprietaire($user);
            $categories->setRestaurant($restaurant);
            $em->persist($categories);
            $em->flush();

            $this->addFlash('success','Votre Categorie a bien été crée');

        }
        
        return $this->render('categories/create.html.twig', [
            'createCategorie' => $form->createView(),
        ]);
    }

      /**
     * @Route("/categories/{id<[0-9]+>}/edit", name="app_edit_categorie", methods={"POST","GET"})
     */
    public function EditCategories(Restaurants $restaurant,CategoriesMenu $categories, Request $request,EntityManagerInterface $em): Response
    {   

        if ($restaurant->getProprietaire() != $this->getUser()) {
            $this->addFlash('error','Accès refusé!!!!');
            return $this->redirectToRoute('app_restaurant'); 
       }
        $user=$this->getUser();
     
        $form=$this->createForm(CategoriesMenuType::class,$categories);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $categories->setProprietaire($user);
            $categories->setRestaurant($restaurant);
            $em->persist($categories);
            $em->flush();

            $this->addFlash('success','Mise à jour éffectuée');

        }
        
        return $this->render('categories/create.html.twig', [
            'createCategorie' => $form->createView(),
        ]);
    }
   
}
