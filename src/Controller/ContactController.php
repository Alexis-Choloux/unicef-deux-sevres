<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\MailerManager;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(
        Request $request,
        MailerManager $mailerManager
        ): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', "Votre demande a bien été prise en compte. Nous reviendrons vers vous dès que nous l'aurons traitée.");
            
            $subject = $form->get('subject')->getData();
            $name = $form->get('firstname')->getData().' '.$form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $content = $form->get('content')->getData();

            $form = "Détail de la demande :<br/><br/>
            Sujet :<br/>".$subject."<br/><br/>
            Nom :<br/>".$name."<br/><br/>
            Adresse mail :<br/>".$email."<br/><br/>
            Message :<br/>".$content;
            $mailerManager->sendEmail($form);
        }
        
        return $this->renderForm('contact/index.html.twig', [
            'form' => $form
        ]);
    }
}
