<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CaisseController extends AbstractController
{
    /**
     * @Route("/caisse/{restaurant}", name="app_caisse")
     */
    public function index(Restaurants $restaurant): Response
    {

        $user=$this->getUser();
            
        if ($user==null | $restaurant->getProprietaire() !== $user ) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_commandes");
        }
        return $this->render('caisse/index.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }
}
