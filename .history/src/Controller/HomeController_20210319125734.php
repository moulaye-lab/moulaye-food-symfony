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
    public function index(Request $request,\Swift_Mailer $mailer ): Response
    {
        $contacts = new Contact;
        
        $form=$this->createForm(ContactFormType::class,$contacts);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message =(new \Swift_Message('Agence : '
            ))
            ->setFrom('noreply@server.com')
            ->setTo('contact@agence.fr')
            ->setReplyTo($contacts->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig',[
                'contact' => $contacts
            ]),
            'text/html');

        
    
            $mailer->send($message);
             return   $this->redirectToRoute('app_home');
          
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
