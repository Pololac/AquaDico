<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Form\NewsletterEmailType;

use App\Newsletter\NewsletterConfirmation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/souscrire', name: 'newsletter_subscribe', methods: ['GET', 'POST'])]
    public function newsletterSubscribe(
        Request $request,
        EntityManagerInterface $em,
        NewsletterConfirmation $notificationService
    ): Response
    {
        $newsletter = new NewsletterEmail();
        $form = $this->createForm(NewsletterEmailType::class, $newsletter);
        
        $form->handleRequest($request);

        // Enregistrement de mon email
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($newsletter);
            $em->flush();
            
        $notificationService->send($newsletter);

        return $this->redirectToRoute('newsletter_confirm');
        }

        return $this->render('newsletter/newsletter.html.twig', [
            'newsletterForm' => $form
        ]);
    }

    #[Route('/newsletter/confirmation', name: "newsletter_confirm")]
    public function newsletterConfirm() : Response{
        return $this->render('newsletter/newsletter_confirm.html.twig');
    }
}
