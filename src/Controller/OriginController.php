<?php

namespace App\Controller;

use App\Entity\Origin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OriginController extends AbstractController
{
    #[Route('/poissons/continent/{id}', name: 'origin_item')]
    public function item(Origin $origin): Response
    {
        return $this->render('origin/list.origin.html.twig', [
            'origin' => $origin,
        ]);
    }
}
