<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatMenuController extends AbstractController
{
    /**
     * @Route("/plat/menu/restaurant/{restaurant}/cat", name="app_plat_menu")
     */
    public function index(): Response
    {
        return $this->render('plat_menu/index.html.twig', [
            'controller_name' => 'PlatMenuController',
        ]);
    }
}
