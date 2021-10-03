<?php

namespace App\Controller;
use App\Entity\Commandes;

use App\Entity\Restaurants;
use App\Repository\CommandesRepository;
use App\Repository\TablesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CaisseController extends AbstractController
{
    /**
     * @Route("/caisse/{restaurant}", name="app_caisse")
     */
    public function index(Restaurants $restaurant,TablesRepository $table,CommandesRepository $repo): Response
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

        $total=0;

        foreach ($commandesByTable as $key => $value) {
            
             if(empty($value['commande'])){

                 unset($commandesByTable[$key]);
             }

             foreach ($value['commande'] as $key => $item) {
                

                $tot=$item->getPrix() * $item->getQuantity();
                $total+=$tot;
             }


        }
       
        dd($key,$total);
   

        return $this->render('caisse/index.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }
}
