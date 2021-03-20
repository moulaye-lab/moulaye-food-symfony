<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ContactNotification $notification,Request $request ): Response
    {
        $contacts = new Contact;
        
        $form=$this->createForm(ContactFormType::class,$contacts);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            public function index($name, \Swift_Mailer $mailer)
            {
                $message = (new \Swift_Message('Hello Email'))
                    ->setFrom('send@example.com')
                    ->setTo('recipient@example.com')
                    ->setBody(
                        $this->renderView(
                            // templates/emails/registration.html.twig
                            'emails/registration.html.twig',
                            ['name' => $name]
                        ),
                        'text/html'
                    )
          
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
