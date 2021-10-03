<?php

namespace App\Controller;

use App\Entity\Tables;
use App\Entity\ImagesResto;
use App\Entity\Restaurants;
use App\Entity\CategoriesMenu;
use App\Entity\CodeReservation;
use App\Form\CodeReservationType;
use App\Repository\TablesRepository;
use App\Repository\PlatMenuRepository;
use App\Repository\ImagesRestoRepository;
use App\Repository\RestaurantsRepository;
use App\Repository\CategoriesMenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerHomeController extends AbstractController
{
    /**
     * @Route("/restaurant/{restaurant<[0-9]+>}/table/{table<[0-9]+>}", name="customer_home")
     */
    public function index(EntityManagerInterface $em, RestaurantsRepository $repo,Restaurants $restaurant,TablesRepository $tableRepo,$table,Request $request): Response
    {   
        $session=$request->getSession();

       $Ntable= $session->set('table',$table);

        dd($Ntable);

            $resto=$repo->findByResto($restaurant);

         $tables=$tableRepo->findOneByNumeroAndResto($table,$restaurant);

         $codeReservation = new CodeReservation;
         $form=$this->createForm(CodeReservationType::class,$codeReservation);
        
         $form->handleRequest($request);
            if($form->isSubmitted() AND $form->isValid()) {
                (string)$codeReservationTable=$tables->getCodeReservation();

                $code=$form->getData('codeReservation');
            
            
            if ( $codeReservationTable == $code->getCodeReservation() ) {
                
                $tables->setCodeReservation(null);
                $tables->setReserved(false);
                
                $em->flush();

                $this->addFlash('success', ' Vous avez désormais accès à votre table /Bon appetit');

                $this->redirectToRoute('customer_home',[
                    
                    'restaurant' => $restaurant->getId(),
                    'table' => $tables->getNumero()
                ]);
            }else{
                $this->addFlash('error', 'Mauvais code de réservation / Réessayer!!!');
                $this->redirectToRoute('customer_home',[
                    
                    'restaurant' => $restaurant->getId(),
                    'table' => $tables->getNumero()
                ]);

            }
               
         }else{
             echo('error');
         }



            

        return $this->render('customer_home/index.html.twig', [
            'resto' => $resto,
            'table' => $tables,
            'codeForm' => $form->createView()
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
     * @Route("/plat/menu/restaurant/{restaurant}/categorie/{categorie}/table/{table}", name="app_plat_menu_customer")
     */
    public function platsMenu( Restaurants $restaurant, PlatMenuRepository $repo, CategoriesMenu $categorie,CategoriesMenuRepository $categorieMenu,Tables $tables): Response
    {


            
           $plats=$repo->findByCatAndResto($categorie);
        
      
               
        return $this->render('customer_home/platmenu.html.twig', [
            'plats' => $plats,
            'categorie' =>$categorie->getId(),
            'restaurant'=>$restaurant->getId()
        ]);
    }


      /**
     * @Route("/restaurant/{restaurant}/info", name="app_infoRestaurant_customer")
     */
    public function RestaurantInfo(ImagesRestoRepository $imagesRestoRepo, Restaurants $restaurant,RestaurantsRepository $repo): Response
    {       $restaurantName=$restaurant->getNom();
            $user=$this->getUser();
            $resto=$repo->findByUserR($user,$restaurantName);
            $imagesResto=$imagesRestoRepo->findByResto($restaurant);

        
        return $this->render('customer_home/restaurant.html.twig', [
            
            'restaurant'=>$restaurant,
            'restos' =>$resto,
            'images' => $imagesResto
        ]);
    }
}
