<?php

namespace App\Controller;

use App\Entity\CategoriesMenu;
use App\Entity\Commandes;
use App\Entity\Restaurants;
use App\Entity\Tables;
use App\Entity\User;
use App\Form\CategoriesMenuType;
use App\Repository\PlatMenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
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

        foreach($panier as $id => $quantity){

            $panierData [] =[
                
                'product' => $plat->find($id),
                'quantity' => $quantity
            ];


            
        }

        $total =0;

        foreach($panierData as $item){

            $totalItem=$item['product']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }

        

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
    public function addQuantity( $id,Request $request,$action): Response
    {
        $session=$request->getSession();

        $panier= $session->get('panier', []);

        if ($action=="add") {
            $panier[$id]++;

        }else if($action=="diminuer"){
           $panier[$id]--;

        }
        $session->set('panier',$panier);


        return $this->redirectToRoute('app_cart_index');

       
    }

    /**
     * @Route("/cart/remove/{id}", name="app_remove_product")
     */
    public function removeProduct( $id,Request $request): Response
    {
        $session=$request->getSession();

        $panier= $session->get('panier', []);

       if(!empty($panier[$id]) ){

        unset($panier[$id]);

        


       }




        $session->set('panier',$panier);


        return $this->redirectToRoute('app_cart_index');




        
       
    }

    /**
     * @Route("/cart/commander", name="app_commander")
     */
    public function Commander( Request $request,EntityManagerInterface $em,PlatMenuRepository $plat): Response
    {
        $session=$request->getSession();

        $panier= $session->get('panier', []);

        $panierData =[];

        foreach($panier as $id => $quantity){

            $panierData [] =[
                
                'product' => $plat->find($id),
                'quantity' => $quantity
            ];

        }


        $restaurant=$session->get('restaurant');


        foreach($panierData as $item){

            $commande= new Commandes;

            $commande->setNomPlat($item['product']->getNom());
           
            $commande->setPrix($item['product']->getPrix());

            $commande->setTableResto($session->get('table'));


            
            $restaurant->addCommande($commande);
           
            $commande->setQuantity($item['quantity']);

            $em->persist($commande);



        }
        
        $em->flush();


        return $this->redirectToRoute('app_cart_index');

       
    }












    
}
