<?php

namespace App\Controller;

use App\Entity\Fish;
use App\Form\SearchType;
use App\Repository\FishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FishController extends AbstractController
{
    #[Route('/poissons', name: 'fishes_list', methods: ['GET'])]
    public function list(Request $request, FishRepository $fishRepository): Response
    {
        $fishes = $fishRepository->findAll();

        $form = $this->createForm(SearchType::class);
                
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $data = $form->getData();
            $query = $data['query'];

            // Effectuer la recherche dans la base de données avec la fonction findBySearchQuery
            $fishes = $fishRepository->findBySearchQuery($query);

            if (empty($fishes)) {
                $this->addFlash('notice', 'Aucun poisson trouvé pour cette recherche.');
            }

           return $this->render('fish/list.html.twig', [
            'form' => $form->createView(),
            'fishes' => $fishes,
            ]);
        }


        return $this->render('fish/list.html.twig', [
            'form' => $form->createView(),
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
