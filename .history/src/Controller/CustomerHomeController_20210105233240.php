<?php

namespace App\Controller;

use App\Entity\Tables;
use App\Entity\Restaurants;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerHomeController extends AbstractController
{
    /**
     * @Route("/restaurant/{restaurant<[0-9]+>}/table/{table<[0-9]+>}", name="customer_home")
     */
    public function index(RestaurantsRepository $repo,Restaurants $restaurant,Tables $tables): Response
    {
            $resto=$repo->findByResto($restaurant);

          


        return $this->render('customer_home/index.html.twig', [
            'resto' => $resto,
            'table'=>$tables
        ]);
    }



    /**
     * @Route("/restaurant/{restaurant<[0-9]+>}/table/{table<[0-9]+>}/menu", name="customer_home_menu", methods={"GET})
     */
    public function menu(RestaurantsRepository $repo,Restaurants $restaurant,Tables $tables): Response
    {
            

          


        return $this->render('customer_home/menu.html.twig', [
           
        ]);
    }
}
