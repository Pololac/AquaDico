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

class FamilyController extends AbstractController
{
    #[Route('/poissons/famille/{slug}', name: 'family_item')]
    public function list(Request $request,
        FishRepository $fishRepository,
        FishFamilyRepository $fishFamilyRepository,
        OriginRepository $originRepository,
        string $slug // Ajout du slug de la famille comme paramètre
        ): Response
    {
      
        $familiesCount = $fishRepository->countByFamily();
        $originsCount = $fishRepository->countByOrigin();
        
        // Recherche de la famille par le slug
        $family = $fishFamilyRepository->findOneBySlug($slug);


        // Récupère les poissons liés à la famille sélectionnée
        $fishes = $fishRepository->createQueryBuilder('f')
            ->join('f.family', 'fa')
            ->where('fa.slug = :familySlug')
            ->setParameter('familySlug', $slug)
            ->getQuery()
            ->getResult();
      
        //RECHERCHE PAR FILTRES AU NIVEAU DES PARAMETRES
        $filterForm = $this->createForm(FilterParametersType::class);
        $filterForm->handleRequest($request);

        $criteria = [];

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $data = $filterForm->getData();

            // Gestion du continent
            if ($data['continent']) {
                $criteria['continent'] = $data['continent'];
            }
            
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

            // Récupère les poissons selon les critères
            $fishes = $fishRepository->findByFilters($criteria);
        }


        return $this->render('family/list.family.html.twig', [
            'filterForm' => $filterForm->createView(),
            'fishes' => $fishes,
            'familiesCount' => $familiesCount,
            'originsCount' => $originsCount,
            'family' => $family,
        ]);
    }
}
