<?php

namespace App\Controller;

use App\Entity\Origin;
use App\Form\FilterParametersType;
use App\Repository\FishFamilyRepository;
use App\Repository\FishRepository;
use App\Repository\OriginRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OriginController extends AbstractController
{
    #[Route('/poissons/continent/{slug}', name: 'origin_item')]
    public function list(
        Request $request,
        FishRepository $fishRepository,
        FishFamilyRepository $fishFamilyRepository,
        OriginRepository $originRepository,
        string $slug // Ajout du slug de la famille comme paramètre
        ): Response
    {
      
        $families = $fishFamilyRepository->findAll();
        $origins = $originRepository->findAll();
        
        // Recherche du continent par ID
        $continent = $originRepository->findOneBySlug($slug);

        // Récupère les poissons liés au continent sélectionné
        $fishes = $fishRepository->createQueryBuilder('f')
            ->join('f.origin', 'o')
            ->where('o.slug = :continentSlug')
            ->setParameter('continentSlug', $slug)
            ->getQuery()
            ->getResult();
            


        //RECHERCHE PAR FILTRES AU NIVEAU DES PARAMETRES
        $filterForm = $this->createForm(FilterParametersType::class);
        $filterForm->handleRequest($request);

        $criteria = [];

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $data = $filterForm->getData();

            // Gestion de la température
            if ($data['temperature']) {
                $tempRange = explode('-', $data['temperature']);
                $criteria['minTemp'] = $tempRange[0];
                $criteria['maxTemp'] = $tempRange[1];
            }

            // Gestion du pH
            if ($data['ph']) {
                $phRange = explode('-', $data['ph']);
                $criteria['minPh'] = $phRange[0];
                $criteria['maxPh'] = $phRange[1];
            }

            // Gestion du GH
            if ($data['gh']) {
                $ghRange = explode('-', $data['gh']);
                $criteria['minGh'] = $ghRange[0];
                $criteria['maxGh'] = $ghRange[1];
            }

            // Gestion de la taille adulte
            if ($data['adultSize']) {
                $sizeRange = explode('-', $data['adultSize']);
                $criteria['minAdultSize'] = $sizeRange[0];
                $criteria['maxAdultSize'] = $sizeRange[1] ?? null;
            }

            // Ajoutez un filtre pour le continent sélectionné
            $criteria['continent'] = $continent->getContinent();

            // Récupère les poissons selon les critères
            $fishes = $fishRepository->findByFilters($criteria);

        }

        return $this->render('origin/list.origin.html.twig', [
            'filterForm' => $filterForm->createView(),
            'fishes' => $fishes,
            'origins' => $origins,
            'families' => $families,
            'selectedContinent' => $continent,
        ]);
    }
}
