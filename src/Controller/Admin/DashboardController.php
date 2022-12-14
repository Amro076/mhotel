<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Entity\Membre;
use App\Entity\Slider;
use App\Entity\Chambre;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mhotel');
    }

    public function configureMenuItems(): iterable
    {
        return 
        [ 
            MenuItem::linkToDashboard('Accueil', 'fa fa-home'),
            MenuItem::section('Main'),
            MenuItem::linkToCrud('chambre', 'fa fa-article', Chambre::class),
            MenuItem::section('Membre'),
            MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', Membre::class),
            MenuItem::section('Commande'),
            MenuItem::linkToCrud('Commande', 'fas fa-user', Commande::class),
            MenuItem::section('Slider'),
            MenuItem::linkToCrud('slider', 'fa fa phpto', Slider::class  ),
            MenuItem::section('Avis'),
            MenuItem::linkToCrud('avis', 'fa fa phpto', Avis::class),
            MenuItem::linkToRoute('Menu_prancipale', 'fas fa-home', 'app_main')
        ];  
    }
}
