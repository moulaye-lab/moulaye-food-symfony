<?php 
namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification  {
    
    /**
     * mailer
     *
     * @var \Swift_Mailer
     */
    private $mailer;
    
    /**
     * renderer
     *
     * @var Environment
     */
    private $renderer;

    
public function __construct(\Swift_Mailer $mailer,Environment $renderer)
{
    $this->mailer=$mailer;
    $this->renderer=$renderer;
    
}

public function notify(Contact $contact) {

    $message =(new \Swift_Message('Agence : ' .$contact->getEmail()))
    ->setFrom('noreply@server.com')
    ->setTo('contact@agence.fr')
    ->setReplyTo($contact->getEmail())
    ->setBody($this->renderer->render('emails/contact.html.twig',[
        'contact' => $contact
    ]),
    'text/html');
    
   $mailer->send($message);
}
        

}


?>

