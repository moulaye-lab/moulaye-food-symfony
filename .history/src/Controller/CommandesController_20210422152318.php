<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandesController extends AbstractController
{
    /**
     * @Route("/commandes", name="app_commandes")
     */
    public function index(RestaurantsRepository $repo): Response
    {

        $user=$this->getUser();

        $restaurantsUser=$repo->findByUser($user);

        if (count($restaurantsUser) == 1) {
            
            return $this->redirectToRoute('app_commandes_restaurant', [

                'id' => $restaurantsUser->getId();


             ] );
        }


        return $this->render('commandes/index.html.twig', [
            'restaurants' => $restaurantsUser,
        ]);
    }
}
