<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Entity\CategoriesMenu;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlatMenuController extends AbstractController
{
    /**
     * @Route("/plat/menu/restaurant/{id}/categorie/{id}", name="app_plat_menu")
     */
    public function index(Request $request, Restaurants $restaurants,CategoriesMenu $categories): Response
    {

                dd($restaurants,$categories);
        return $this->render('plat_menu/index.html.twig', [
            'controller_name' => 'PlatMenuController',
        ]);
    }
}
