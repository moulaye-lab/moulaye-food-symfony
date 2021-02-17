<?php

namespace App\Controller;

use App\Entity\Tables;
use App\Entity\Restaurants;
use App\Entity\CategoriesMenu;
use App\Repository\PlatMenuRepository;
use App\Repository\RestaurantsRepository;
use App\Repository\CategoriesMenuRepository;
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
     * @Route("/restaurant/{restaurant<[0-9]+>}/table/{table<[0-9]+>}/menu", name="customer_home_menu", methods={"GET"})
     */
    public function menu(CategoriesMenuRepository $repo,Restaurants $restaurant,Tables $tables): Response
    {
            
        $categorie= $repo->findByResto($restaurant);

          


        return $this->render('customer_home/menu.html.twig', [
           'categorie' => $categorie,
           'restaurant' => $restaurant,
           'table' => $tables
        ]);
    }



    /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}", name="app_plat_menu_customer")
     */
    public function platsMenu( Restaurants $restaurant, PlatMenuRepository $repo, CategoriesMenu $categorie,CategoriesMenuRepository $categorieMenu): Response
    {


            
           $plats=$repo->findByCatAndResto($categorie);
        
      
               
        return $this->render('customer_home/platmenu.html.twig', [
            'plats' => $plats,
            'categorie' =>$categorie,
            'restaurant'=>$restaurant
        ]);
    }


      /**
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}", name="app_plat_menu_customer")
     */
    public function RestaurantInfo( Restaurants $restaurant): Response
    {


            
           $plats=$repo->findByCatAndResto($categorie);
        
      
               
        return $this->render('customer_home/platmenu.html.twig', [
            'plats' => $plats,
            'categorie' =>$categorie,
            'restaurant'=>$restaurant
        ]);
    }
}
