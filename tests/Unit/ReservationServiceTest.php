<?php

namespace App\Tests\Unit;

use App\Entity\Salle;
use App\Entity\Seance;
use PHPUnit\Framework\TestCase;
use App\Service\ReservationService;

class ReservationServiceTest extends TestCase
{
    // Tester que l'on peut reserver si des places sont disponilbles
    public function testPeutReserverSiPlacesDisponibles(): void
    {
        $salle = new Salle();
        $salle->setCapacite(50);

        $seance = new Seance();
        $seance->setSalle($salle);

        $reservationService = new ReservationService();

        $this->assertTrue($reservationService->peutReserver($seance));
    }

    // Tester que l'on ne peut pas reserver si complete
    public function testNePeutPasReserverSiComplete(): void 
    {
        $salle = new Salle();
        $salle->setCapacite(0);

        $seance = new Seance();
        $seance->setSalle($salle);

        $reservationService = new ReservationService();

        $this->assertFalse($reservationService->peutReserver($seance));
    }
}