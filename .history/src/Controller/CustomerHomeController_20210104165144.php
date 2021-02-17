<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerHomeController extends AbstractController
{
    /**
     * @Route("/restaurant/{id<[0-9]+>}home", name="customer_home")
     */
    public function index(RestaurantsRepository $repo): Response
    {
        return $this->render('customer_home/index.html.twig', [
            'controller_name' => 'CustomerHomeController',
        ]);
    }
}
