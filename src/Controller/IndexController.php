<?php

namespace App\Controller;

use App\Repository\FishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(FishRepository $fishRepository): Response
    {

        $fishes = $fishRepository->findAll();
        $familiesCount = $fishRepository->countByFamily();
        $originsCount = $fishRepository->countByOrigin();


        return $this->render('index/index.html.twig', [
            'fishes' => $fishes,
            'familiesCount' => $familiesCount,
            'originsCount' => $originsCount,
            ]);
    }
    
    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('index/about.html.twig', [
        ]);
    }
}
