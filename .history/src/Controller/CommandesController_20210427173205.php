<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Repository\CommandesRepository;
use App\Repository\RestaurantsRepository;
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
    public function Commandes(CommandesRepository $repo , Restaurants $restaurant): Response
    {
        $user=$this->getUser();
            
        if ($user==null | $restaurant->getProprietaire() !== $user ) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_commandes");
        }
           

        $tables=[];
            $commandes=$repo->findByRestaurant($restaurant);
           
            foreach ($commandes as $item ) {
                $tables=[] = [
                    $tables=$item->getTableResto()

                ];
               
               

            }

            dd($tables);
            
       

        return $this->render('commandes/commandesByRestaurant.html.twig', [
            
            'commandes' => $commandes
        ]);
    }
}
