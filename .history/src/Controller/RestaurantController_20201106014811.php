<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Restaurants;
use App\Form\CreateRestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestaurantsRepository;
use App\Repository\UserRepository;
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
        if ($this->getUser()===null ) {
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
    public function CreateRestaurant(UserRepository $user,Request $request,EntityManagerInterface $em): Response
    {   
        
        $restaurant=new Restaurants;
        $form=$this->createForm(CreateRestaurantType::class,$restaurant);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $restaurant->setProprietaire($this->getUser());
            $em->persist($restaurant);
            $em->flush();

            $this->addFlash('success','Votre Restaurant a bien été crée');

        }
        
        return $this->render('restaurant/create.html.twig', [
            'createResto' => $form->createView(),
        ]);
    }

    /**
     * @Route("/restaurant/{id<[0-9]+>}/edit", name="app_edit_restaurant", methods={"POST","GET"})
     */
    public function editRestaurant(Restaurants $restaurant,Request $request,EntityManagerInterface $em): Response
    {   
        
       
        $form=$this->createForm(CreateRestaurantType::class,$restaurant);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $restaurant->setProprietaire($this->getUser());
            $em->persist($restaurant);
            $em->flush();

            $this->addFlash('success','Mise à jour effectuer');

        }
        
        return $this->render('restaurant/edit.html.twig', [
            'createResto' => $form->createView(),
            'restaurant' => $restaurant
        ]);
    }

     /**
     * @Route("/restaurant/{id<[0-9]+>}/edit", name="app_gerer_restaurant", methods={"POST","GET"})
     */
    public function gererRestaurant(Restaurants $restaurant,Request $request,EntityManagerInterface $em): Response
    {   
        
       


        
        
        return $this->render('restaurant/edit.html.twig', [
            'restaurant' => $restaurant
        ]);
    }


    
    /**
     * delete
     *
     * @Route("/restaurant/{id}/delete", name="app_delete_restaurant" ,methods="DELETE")  // {id<[0-9]+>} signifie que le id doit etre un nombre
     */
    public function delete(Request $request,Restaurants $restaurant,EntityManagerInterface $manager) : Response
    {

        if ($restaurant->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute('app_restaurant');
        }
        if ($this->isCsrfTokenValid('pin_deletion_'.$restaurant->getId(), $request->request->get('csrf_token'))) {
           
        }
        $manager->remove($restaurant);
        $manager->flush();
        

        $this->addFlash('success','Votre Restaurant a bien été supprimer');

        
        return $this->redirectToRoute('app_restaurant');   

    }

}
