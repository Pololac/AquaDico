<?php

namespace App\Controller;

use App\Form\FilterParametersType;
use App\Repository\FishFamilyRepository;
use App\Repository\FishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FamilyController extends AbstractController
{
    #[Route('/poissons/famille/{slug}', name: 'family_item')]
    public function list(
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        FishRepository $fishRepository,
        FishFamilyRepository $fishFamilyRepository,
        string $slug // Ajout du slug de la famille comme paramètre
        ): Response
    {
      
        $familiesCount = $fishRepository->countByFamily();
        $originsCount = $fishRepository->countByOrigin();
        
        // Recherche de la famille par le slug
        $family = $fishFamilyRepository->findOneBySlug($slug);

        // Récupère les poissons liés à la famille sélectionnée
        $fishes = $fishRepository->findByFamily($slug);
        $visibleFishes = array_filter($fishes, function($fish) {
            return $fish->isVisible();
        });
        
        //RECHERCHE PAR FILTRES AU NIVEAU DES PARAMETRES
        $filterForm = $this->createForm(FilterParametersType::class);
        $filterForm->handleRequest($request);

        $criteria = [];

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $data = $filterForm->getData();

            $criteria['family'] = $family;

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
            $visibleFishes = array_filter($fishes, function($fish) {
                return $fish->isVisible();
            });
        }

        // Générer l'URL actuelle sans les paramètres GET pour la réinitialisation
        $currentUrl = $urlGenerator->generate($request->attributes->get('_route'), 
        ['slug' => $slug], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->render('family/list.family.html.twig', [
            'filterForm' => $filterForm->createView(),
            'fishes' => $visibleFishes,
            'familiesCount' => $familiesCount,
            'originsCount' => $originsCount,
            'family' => $family,
            'currentUrl' => $currentUrl,  // URL sans paramètres GET pour la réinitialisation
        ]);
    }
}
