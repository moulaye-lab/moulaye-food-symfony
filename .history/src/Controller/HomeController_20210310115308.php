<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ContactNotification $notification): Response
    {
        $contacts = new Contact;
        
        $form=$this->createForm(ContactFormType::class,$contacts);
        
        if ($form->isSubmitted() AND $form->isValid() ){
           $a=$notification;


            $this->addFlash('success', 'Votre mail à bien été envoyé');
        }


        $user=$this->getUser();
        return $this->render('home/index.html.twig', [
            'user' => $user,
            'contactForm' => $form->createView()
        ]);
    }


     /**
     * @Route("/home_user", name="app_home_user")
     */
    public function index_user(): Response
    {
        





        
        return $this->render('home/index_user.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }



    
}
