<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Restaurants;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte/{id<[0-9]+>}", name="app_compte")
     */
    public function index(User $user,RestaurantsRepository $repoResto,UserPasswordEncoderInterface $passwordEncoder,Restaurants $resto,Request $request,EntityManagerInterface $em): Response
    {
        if ( $this->getUser() != $user | $this->getUser()==null ) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }

           $restaurants=$repoResto->findByUser($user); 

           $form=$this->createForm(UserType::class,$user);

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Modification effectuée");
            
           }



        $formPassword = $this->createForm(ResetPasswordType::class, $user);

    	$formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {


            $oldPassword = $formPassword->get('oldPassword')->getData();

           

            // Si l'ancien mot de passe est bon

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {

                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());

                $user->setPassword($newEncodedPassword);

                

                $em->persist($user);

                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('app_compte',[

                    'id'=> $this->getUs
                ]);

            } else {

                $this->addFlash('error','Ancien mot de passe incorrect');

            }
           }


       
        return $this->render('compte/index.html.twig', [
            'user' => $user,
            "editUserForm" => $form->createView(),
            'restaurants' => $restaurants,
            "formPassword" => $formPassword->createView()

        ]);
    }


    


}
   