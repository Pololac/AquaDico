<?php

namespace App\Controller;

use App\Entity\Fish;
use App\Repository\FishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FishController extends AbstractController
{
    #[Route('/fishes', name: 'fishes_list')]
    public function list(FishRepository $fishRepository): Response
    {
        $fishes = $fishRepository->findAll();

        return $this->render('fish/list.html.twig', [
            'fishes' => $fishes,
        ]);
    }

    #[Route('/fish/{id}', name: 'fish_item')]
    public function item(Fish $fish): Response
    {        
         return $this->render('fish/item.html.twig', [
                'fish' => $fish,
        ]);     // ERREUR 404 générée automatiquement

    }
}
