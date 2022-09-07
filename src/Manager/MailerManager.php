<?php

namespace App\Manager;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerManager
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function sendEmail($form): Response
    {
        $email = (new Email())
            ->from('unicef79@unicef.fr')
            ->to('unicef79@unicef.fr')
            ->subject('Formulaire contact - unicef-deux-sevres.fr')
            ->text($form)
            ->html($form);

        $this->mailer->send($email);

        return new Response(1);
    }
}
