<?php 

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MyMailer
{
    private $mailer;
    
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }



    public function sendContactMail ( string $firstname, string $lastname, string $emailAddress, string $subject, string $message)
    {
        $email = (new Email())
        ->from('postmaster@sandbox4ce6206048e8404d892fa0f46680b3f1.mailgun.org')
        ->to('laurent.matheu@hotmail.fr')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject($subject)
        ->text("Prénom : {$firstname}\nNom : {$lastname}\nAdresse mail : $emailAddress\nMessage : {$message}");
        
    $this->mailer->send($email);
    }
    public function sendCredentialsMail ( string $firstname, string $lastname, string $emailAddress, string $password)
    {
        $email = (new Email())
        ->from('postmaster@sandbox4ce6206048e8404d892fa0f46680b3f1.mailgun.org')
        ->to('laurent.matheu@hotmail.fr')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject("Votre compte a été créé")
        ->text("{$firstname} {$lastname}\nVotre profil a bien été validé pour participer à notre festival !!!\nRetrouvez ci dessous vos identifiants et pensez à mettre à jour votre mot de passe dans votre profil :\nAdresse mail : $emailAddress\nMot de passe (à changer)  : {$password}");
        
    $this->mailer->send($email);
    }

    public function sendNewPassword ( string $password)
    {
        $email = (new Email())
        ->from('postmaster@sandbox4ce6206048e8404d892fa0f46680b3f1.mailgun.org')
        ->to('laurent.matheu@hotmail.fr')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject("Mot de passe oublié")
        ->text("Voici votre nouveau mot de passe : {$password} ");
        
    $this->mailer->send($email);
    }

    public function sendValidationMail()
    {
        $email = (new Email())
        ->from('postmaster@sandbox4ce6206048e8404d892fa0f46680b3f1.mailgun.org')
        ->to('laurent.matheu@hotmail.fr')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject("Truck validé")
        ->text("Votre foodtruck a bien été validé pour participer à notre évenement et est dès à présent visible dans sur notre site.");
        
    $this->mailer->send($email);
    }

    public function sendRefusalMail()
    {
        $email = (new Email())
        ->from('postmaster@sandbox4ce6206048e8404d892fa0f46680b3f1.mailgun.org')
        ->to('laurent.matheu@hotmail.fr')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject("Truck refusé")
        ->text("Votre foodtruck a été refusé pour participer à notre évenement et est a nouveau visible dans votre profil.");
        
    $this->mailer->send($email);
    }
}