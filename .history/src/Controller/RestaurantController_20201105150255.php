<?php

namespace App\Controller;

use App\Entity\Restaurants;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant", name="app_restaurant")
     */
    public function index(RestaurantsRepository $repo): Response
    {       
        $user=$this->getUser()->getId();
        $restaurants= $repo->findByUser($user);
        
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }


     /**
     * @Route("/restaurant/{id<[0-9]+>}/create", name="app_create_restaurant" methods={"GET","POST"})
     */
    public function CreateRestaurant(Restaurants $restaurant,Request $request,EntityManagerInterface $em): Response
    {       
        $user=$this->getUser()->getId();
        $restaurants= $repo->findByUser($user);
        
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }
}
