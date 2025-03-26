<?php

namespace App\Newsletter;

use App\Entity\NewsletterEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NewsletterConfirmation
{

    public function __construct(
        private MailerInterface $mailer,
        private string $adminEmail
    ){

    }

    public function send(NewsletterEmail $newsletterEmail)
    {
        $email = (new Email())
            ->from($this->adminEmail)
            ->to($newsletterEmail->getEmail())
            ->subject('Aqua Dico - Inscription à la newsletter')
            ->text('Votre email a bien été ajouté à notre liste de diffusion de la newsletter !')
            ->html('<p>Votre email a bien été ajouté à notre liste de diffusion de la newsletter !</p>');

        $this->mailer->send($email);
    }
}
