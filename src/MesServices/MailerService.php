<?php 

namespace App\MesServices;

use App\Entity\User;
use App\Entity\Commande;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendContactMail(array $data)
    {
        $email = (new TemplatedEmail())
                ->from('contact@symfonyecommerce.com')
                ->to('contact@symfonyecommerce.com')
                ->subject($data['subject'])

                // path of the Twig template to render
                ->htmlTemplate('emails/email_contact.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'subject' => $data['subject'],
                    'content' => $data['content'],
                    'email_customer' => $data['email'],
                ])
            ;

        $this->mailer->send($email);
    }

    public function sendCommandMail(Commande $commande, User $user, )
    {
        $email = (new TemplatedEmail())
                ->from('contact@dmstore.com')
                ->to($user->getEmail())
                ->subject('Commande n°' . $commande->getId())

                ->htmlTemplate('emails/email_command_customer.html.twig')

                ->context([
                    'user' => $user,
                    'adress' => $user->getAdress(),
                    'id' => $commande->getId(),
                    'total' => $commande->getTotal(),
                    'date' => $commande->getDate(),
                    'contents' => $commande->getCommandeListProduct()->getContentLists(),

                ])
            ;

        $this->mailer->send($email);
        
    }
}    