<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Repository\CategoriesMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            return $this->redirectToRoute('app_gestion_menu'); 
       }
           
            $user=$this->getUser()->getId();
            $categories= $repo->findByResto($restaurants);
            
           
        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
            'restaurant' => $restaurants,
            'user' => $this->getUser()
        ]);
    }
}
