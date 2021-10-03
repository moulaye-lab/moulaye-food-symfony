<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\Restaurants;
use App\Repository\CommandesRepository;
use App\Repository\RestaurantsRepository;
use App\Repository\TablesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandesController extends AbstractController
{
    /**
     * @Route("/commandes", name="app_commandes")
     */
    public function index(RestaurantsRepository $repo): Response
    {

        $user=$this->getUser();

        if ($user==null ) {
            $this->addFlash('error','NON! NON! VEUILLEZ VOUS CONNECTER');
            return $this->redirectToRoute('app_login');
        }

        $restaurantsUser=$repo->findByUser($user);

        if (count($restaurantsUser) == 1) {
            
            return $this->redirectToRoute('app_commandes_restaurant', [

                'id' => $restaurantsUser->getId()


             ] );
        }


        return $this->render('commandes/index.html.twig', [
            'restaurants' => $restaurantsUser,
        ]);
    }



    /**
     * @Route("/commandes/restaurant/{restaurant}", name="app_commandes_restaurant")
     */
    public function Commandes(CommandesRepository $repo , TablesRepository $table , Restaurants $restaurant): Response
    {
        $user=$this->getUser();
            
        if ($user==null | $restaurant->getProprietaire() !== $user ) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_commandes");
        }

            $commandes=$repo->findByRestaurant($restaurant);

            $tables=$table->findByResto($restaurant);


           $commandesByTable=[
               
            ]; 
           foreach ($tables as $id=>$tabl) {
            
                
              
                $commandesByTable[]=[
                    
                  'table' =>$tabl->getNumero(),
                  'commande'=>$repo->findByTableResto($tabl->getNumero())
                
                ];

           }

           foreach ($commandesByTable as $key => $value) {
               
                if(empty($value['commande'])){

                    unset($commandesByTable[$key]);
                }

           }

           

           
        return $this->render('commandes/commandesByRestaurant.html.twig', [
            
            'commandes' => $commandes,
            'restaurant' => $restaurant,
            'commandesByTable' => $commandesByTable

        ]);
    }


/**
     * @Route("/commandes/{commande<[0-9]+>}/{restaurant}", name="app_commande_servi")
     */
    public function Servi(EntityManagerInterface $em, RestaurantsRepository $repo,Restaurants $restaurant, Commandes $commande): Response
    {

        $user=$this->getUser();

        if ($user==null | $restaurant->getProprietaire() !== $user ) {
            $this->addFlash('error','NON! NON! VEUILLEZ VOUS CONNECTER');
            return $this->redirectToRoute('app_commandes');
        }

       $commande->setServi(true);
       $em->flush();

       return $this->redirectToRoute('app_commandes_restaurant',[

            'restaurant' => $restaurant->getId()
       ]);

    }












}



