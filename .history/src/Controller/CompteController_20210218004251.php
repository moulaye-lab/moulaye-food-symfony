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

           $restaurants=$repoResto->findByUser($user); 

           $form=$this->createForm(UserType::class,$user);

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Modification effectuée");
            
           }

       
        return $this->render('compte/index.html.twig', [
            'user' => $user,
            "editUserForm" => $form->createView(),
            'restaurants' => $restaurants
        ]);
    }


    
    /**
     * editAction
     *
     * @param  mixed $request
     * @return void
     */
    public function editAction(Request $request)

    {

    	$em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

    	$form = $this->createForm(ResetPasswordType::class, $user);

    	$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $passwordEncoder = $this->get('security.password_encoder');

            $oldPassword = $request->request->get('etiquettebundle_user')['oldPassword'];

            // Si l'ancien mot de passe est bon

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {

                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());

                $user->setPassword($newEncodedPassword);

                

                $em->persist($user);

                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('profile');

            } else {

                $this->addFlash('error','Ancien mot de passe incorrect');

            }


            return $this->render('compte/index.html.twig', [

                'formPassword' =>$form->createView()
            ]);
    

        }

    	

    	
    }
}
