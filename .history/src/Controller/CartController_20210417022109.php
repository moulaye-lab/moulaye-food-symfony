<?php

namespace App\Controller;

use App\Entity\CategoriesMenu;
use App\Entity\Restaurants;
use App\Entity\Tables;
use App\Form\CategoriesMenuType;
use App\Repository\PlatMenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart_index")
     */
    public function index(SessionInterface $session, PlatMenuRepository $plat): Response
    {

        $panier= $session->get('panier',[]);
        $panierData =[];

        foreach((array) $panier as $id => $quantity){

            $panierData [] =[
                
                'product' => $plat->find($id),
                'quantity' => $quantity
            ];


            
        }

        $total =0;

       $total=5;

        

        return $this->render('cart/index.html.twig', [
            'items' => $panierData,
            'total' => $total
        ]);
    }


    /**
     * @Route("/cart/add/{id}/{restaurant}/{categorie}", name="app_cart")
     */
    public function add($id, Request $request,Restaurants $restaurant, CategoriesMenu $categorie): Response
    {
        $session=$request->getSession();

        $panier= $session->get('panier', []);
        
        if(!empty($panier[$id])){

            $panier[$id]++;
        }else{
            $panier[$id] =1;

        }
        
     

        $session->set('panier',$panier);

        return $this->redirectToRoute('app_plat_menu_customer',[
            'restaurant' => $restaurant->getId(),
            'categorie' => $categorie->getId()
        ]);

        
    }


    /**
     * @Route("/cart/addQuantity/{id}/{action}", name="app_add_quantity")
     */
    public function addQuantity( $id,Request $request,$action)
    {
        $session=$request->getSession();

        $panier= $session->get('panier', []);


        if ($action="add") {
            $panier[$id]++;

        }elseif($action="dim"){
        }
        $session->set('panier',$panier);



       
    }
}
