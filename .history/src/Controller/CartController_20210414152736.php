<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="aap_cart")
     */
    public function index(): Response
    {
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
        }

        $panier[$id] =1;

        $session->set('panier',$panier);

        dd($session->get('panier'));
        

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
