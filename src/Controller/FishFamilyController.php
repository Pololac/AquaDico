<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FishFamilyController extends AbstractController
{
    #[Route('/fish/family', name: 'app_fish_family')]
    public function index(): Response
    {
        return $this->render('fish_family/index.html.twig', [
            'controller_name' => 'FishFamilyController',
        ]);
    }
}
