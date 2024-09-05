<?php

namespace App\Controller;

use App\Entity\FishFamily;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FamilyController extends AbstractController
{
    #[Route('/poissons/famille/{id}', name: 'family_item')]
    public function item(FishFamily $family): Response
    {
        return $this->render('family/list.html.twig', [
            'family' => $family,
        ]);
    }
}
