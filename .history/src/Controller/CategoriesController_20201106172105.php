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
           
            $user=$this->getUser()->getId();
            $categories= $repo->findByUser($user,$restaurants);
            
           
        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
            'restaurant' => $restaurants
        ]);
    }
}
