<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerHomeController extends AbstractController
{
    /**
     * @Route("/restaurant/{restaurant<[0-9]+>}/table/{table<[0-9]+>}", name="customer_home")
     */
    public function index(RestaurantsRepository $repo,Restaurant $restaurant): Response
    {



        return $this->render('customer_home/index.html.twig', [
            'controller_name' => 'CustomerHomeController',
        ]);
    }
}
