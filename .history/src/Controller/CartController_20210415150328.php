<?php

namespace App\Controller;

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

        foreach($panier as $id => $quantity){

            $panierData [] =[
                
                'product' => $plat->find($id),
                'quantity' => $quantity
            ];
        }
        dd($panierData);



        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }


    /**
     * @Route("/cart/add/{id}", name="app_cart")
     */
    public function add($id, Request $request): Response
    {
        $session=$request->getSession();

        $panier= $session->get('panier', []);
        
        if(!empty($panier[$id])){

            $panier[$id]++;
        }else{
            $panier[$id] =1;

        }


        $session->set('panier',$panier);

        

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
