<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OriginController extends AbstractController
{
    #[Route('/origin', name: 'app_origin')]
    public function index(): Response
    {
        return $this->render('origin/index.html.twig', [
            'controller_name' => 'OriginController',
        ]);
    }
}
