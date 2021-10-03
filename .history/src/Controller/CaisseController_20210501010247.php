<?php

namespace App\Controller;
use App\Entity\Commandes;

use App\Entity\Restaurants;
use App\Repository\CommandesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CaisseController extends AbstractController
{
    /**
     * @Route("/caisse/{restaurant}", name="app_caisse")
     */
    public function index(Restaurants $restaurant,CommandesRepository $repo): Response
    {

        $user=$this->getUser();
            
        if ($user==null | $restaurant->getProprietaire() !== $user ) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_commandes");
        }

        $commandes=$repo->findByRestaurant($restaurant);

        dd($commandes);

        return $this->render('caisse/index.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }
}
