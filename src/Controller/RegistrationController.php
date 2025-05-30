<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        Security $security,
        EntityManagerInterface $em
        ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                // Ajoutez un log ou affichez l'erreur
                echo $error->getMessage();
            }

            // Encodage du mot de passe et enregistrement de l'utilisateur dans la BDD
            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login', ['successMessage' => 'Inscription réussie ! Vous pouvez vous connecter.']);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    // #[Route('/register/thanks', name: "registration_confirm")]
    // public function newsletterConfirm() : Response{
    //     return $this->render('registration/registration.html.twig');
    // }
}
