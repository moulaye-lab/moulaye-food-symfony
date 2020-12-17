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
        if ($this->getUser()===null) {
            $this->addFlash('error','Diantre veuillez vous connecter pour y acceder!!!!');
            return $this->redirectToRoute('app_login');  //si le user est deja connecter on le redirige vers la page d'acceuil
       }
           
            $user=$this->getUser()->getId();
            $restaurants= $repo->findByUser($user);
            
            return $this->render('restaurant/index.html.twig', [
                'restaurants' => $restaurants,
            ]);
    
        
       
    }


     /**
     * @Route("/restaurant/create", name="app_create_restaurant", methods={"POST","GET"})
     */
    public function CreateRestaurant(Request $request,EntityManagerInterface $em): Response
    {   
        $user=$this->getUser()->getId();
        $restaurant=new Restaurants;
        $form=$this->createForm(CreateRestaurantType::class,$restaurant);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $restaurant->setProprietaire($user);
            $em->persist($restaurant);
            $em->flush();

            $this->addFlash('success','Votre Restaurant a bien été crée');

        }
        
        return $this->render('restaurant/create.html.twig', [
            'createResto' => $form->createView(),
        ]);
    }
}
