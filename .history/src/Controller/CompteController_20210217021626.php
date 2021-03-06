<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Restaurants;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte/{id<[0-9]+>}", name="app_compte")
     */
    public function index(User $user,RestaurantsRepository $repoResto,Restaurants $resto,Request $request,EntityManagerInterface $em): Response
    {
        if ( $this->getUser() != $user | $this->getUser()==null ) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }

           $restaurants=$repoResto-> 

           $form=$this->createForm(UserType::class,$user);

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Modification effectuée");
            
           }

       
        return $this->render('compte/index.html.twig', [
            'user' => $user,
            "editUserForm" => $form->createView()
        ]);
    }
}
