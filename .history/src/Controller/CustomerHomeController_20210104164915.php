<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerHomeController extends AbstractController
{
    /**
     * @Route("/customer/home", name="customer_home")
     */
    public function index(): Response
    {
        return $this->render('customer_home/index.html.twig', [
            'controller_name' => 'CustomerHomeController',
        ]);
    }
}
