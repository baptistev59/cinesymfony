<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Entity\Seance;

class ReservationService
{
 
    /**
     * Renvoie le nombre de places restantes pour une séance donnée
     * 
     * @param Seance $seance
     * @return int
     */

    public function placesRestantes(Seance $seance): int
    {
        $placesReservees = 0;

        foreach ($seance->getReservations() as $reservation) {
            if (!$reservation->getStatut() === Reservation::STATUTS_CONFIRMEE) {
                $placesReservees += $reservation->getNombrePlaces();
            }
        }

        return $seance->getSalle()->getCapacite() - $placesReservees;
    }    
 
    /**
     * Renvoie vrai si la séance a encore des places disponibles
     * 
     * @param Seance $seance
     * @return bool
     */

    public function peutReserver(Seance $seance): bool
    {
        return $this->placesRestantes($seance) > 0;
    }
}