<?php

namespace App\Controller\Admin;

use App\Entity\FishFamily;
use App\Entity\Origin;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(FishCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<class="img-fluid d-block mx-auto" style="max-width:100px; width:100%;"><h2 class="mt-3 fw-bold text-gray text-center">AquaDico Dashboard</h2>');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Retour sur la page d\'accueil', 'fas fa-home', $this->generateUrl('homepage'));
        yield MenuItem::linkToDashboard('Poissons', 'fa-solid fa-fish');
        yield MenuItem::linkToCrud('Familles', 'fa-solid fa-group-arrows-rotate', FishFamily::class);
        yield MenuItem::linkToCrud('Origine', 'fa-solid fa-earth-americas', Origin::class);

    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->renderContentMaximized()
            ->setDefaultSort([
                'id' => 'DESC',
            ])
            ->setPaginatorPageSize(15)
            ->showEntityActionsInlined(true);
    }
}
