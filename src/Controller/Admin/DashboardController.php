<?php

namespace App\Controller\Admin;

use App\Entity\Film;
use App\Entity\Salle;
use App\Entity\Reservation;
use App\Entity\Seance;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {

        return $this->render('dashboard.html.twig');
        
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cine Symfony');
    }

    public function configureMenuItems(): iterable
    {        
        // Retour au site
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-home', 'app_programmation');
        // Films
        yield MenuItem::linkToCrud('Films', 'fas fa-film', Film::class);
        // Utilisateurs
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', Utilisateur::class);
        //salles
        yield MenuItem::linkToCrud('Salles', 'fas fa-theater-masks', Salle::class);
        // seances
        yield MenuItem::linkToCrud('Séances', 'fas fa-calendar', Seance::class);
        // reservations
        yield MenuItem::linkToCrud('Réservations', 'fas fa-ticket-alt', Reservation::class);

        
    }
}
