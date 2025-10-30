<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CinemaController extends AbstractController
{
    #[Route('/programmation', name: 'app_programmation')]
    public function programmation(FilmRepository $filmRepository): Response
    {
        $films = $filmRepository->findAll();
        return $this->render('cinema/programmation.html.twig', [
            'films' => $films
        ]);
    }

    // Gestion des profils utilisateurs avec les réservations
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        return $this->render('cinema/reservation.html.twig');
    }

    // Annulation d'une réservation
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/annuler-reservation/{id}', name: 'annuler_reservation')]
    public function cancelReservation(Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que la réservation appartient à l'utilisateur connecté
        $user = $this->getUser();
        if ($reservation->getUtilisateur() === $user) {
            // Modifer le statut de la reservation en annulée
            $reservation->setStatut('ANNULEE');
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_profil');
    }

    // création d'une reservation
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/reserver/{id}', name: 'app_reserver')]
    public function reservation(Seance $seance, Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setSeance($seance)
                        ->setUtilisateur($this->getUser())
                        ->setStatut(Reservation::STATUTS_CONFIRMEE);

            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('cinema/reserver.html.twig', [
            'seance' => $seance,
            'form' => $form->createView()
        ]);
    }
}

