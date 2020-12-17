<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Form\CreateRestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant", name="app_restaurant")
     */
    public function index(RestaurantsRepository $repo): Response
    {       
        $user=$this->getUser()->getId();
        $restaurants= $repo->findByUser($user);
        
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }


     /**
     * @Route("/restaurant/{id<[0-9]+>}/create", name="app_create_restaurant" methods={"GET","POST"})
     */
    public function CreateRestaurant(Restaurants $restaurant,Request $request,EntityManagerInterface $em): Response
    {       
        $restaurant=new Restaurants;
        $form=$this->createForm(CreateRestaurantType::class,$restaurant);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->addFlash('success','Votre Restaurant a bien été crée');

            return $this->redirectToRoute('app_restaurant');
        }
        
        return $this->render('restaurant/create.html.twig', [
            'createResto' => $restaurant,
        ]);
    }
}
