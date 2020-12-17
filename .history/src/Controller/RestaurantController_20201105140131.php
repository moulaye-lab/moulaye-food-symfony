<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant", name="app_restaurant")
     */
    public function index(RestaurantsRepository $repo): Response
    {       
        $user=$this->getUser()->getId();
        $restaurants= $repo->findByUser();
        
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }
}
