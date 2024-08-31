<?php

namespace App\Controller;

use App\Entity\Fish;
use App\Entity\FishFamily;
use App\Repository\FishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FishController extends AbstractController
{
    #[Route('/poissons', name: 'fishes_list')]
    public function list(FishRepository $fishRepository): Response
    {
        $fishes = $fishRepository->findAll();

        return $this->render('fish/list.html.twig', [
            'fishes' => $fishes,
        ]);
    }

    #[Route('/poissons/{id}', name: 'fish_item')]
    public function item(Fish $fish): Response
    {        
         return $this->render('fish/item.html.twig', [
                'fish' => $fish,
        ]);     // ERREUR 404 générée automatiquement

    }

    // #[Route('/poissons/{name}', name: 'fishfamily_item')]
    // public function familylist(FishRepository $fishRepository, FishFamily $fishfamily): Response
    // {      
    //     $fishes = $fishRepository->findBy(family_id)

    //     return $this->render('fish/list.html.twig', [
    //             'fishes' => $fishes,
    //     ]);     // ERREUR 404 générée automatiquement

    // }


}
