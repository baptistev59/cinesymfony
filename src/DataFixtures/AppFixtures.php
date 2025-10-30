<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Film;
use App\Entity\Salle;
use App\Entity\Seance;
use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Repository\SalleRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher) {}

    public function load(ObjectManager $manager): void
    {
    
        $faker = Factory::create('fr_FR');

        $genres = ['Action', 'Aventure', 'Comédie', 'Drame', 'Horreur', 'Science-fiction', 'Romance', 'Thriller', 'Animation', 'Documentaire'];
        $langes = ['VF', 'VO', 'VOSTFR'];
        // boucle pour créer 6 films
        $films = [];
        for ($i = 0; $i < 6; $i++) {
            $film = new Film();
            $film->setTitre(ucwords($faker->sentence(3)))
                ->setDuree($faker->numberBetween(80, 180))
                ->setGenre($genres[array_rand($genres)])
                ->setLangue($langes[array_rand($langes)]);

            $films[] = $film;
            $manager->persist($film);
        }

        $salles = [];
        // boucle pour créer 3 Salles
        for ($i = 0; $i < 3; $i++) {
            $salle = new Salle();
            $salle->setNumero($i + 1);
            $salles[] = $salle;
            $manager->persist($salle);
        }

        // Boucle pour créer 20 Seances
        $seances = [];
        for ($i = 0; $i < 20; $i++) {
            $seance = new Seance();
            $seance->setDate($faker->dateTimeBetween('now', '+1 month'));
            $seance->setFilm($faker->randomElement($films));
            $seance->setSalle($faker->randomElement($salles));

            $seances[] = $seance;

            $manager->persist($seance);
        }

        // boucle pour créer 5 utilisateurs
        $utilisateurs = [];
        for ($i = 0; $i < 5; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur
                ->setEmail($faker->unique()->safeEmail())
                ->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $utilisateur,
                        '123'
                    )
                );
            $utilisateurs[] = $utilisateur;
            $manager->persist($utilisateur);
        }

        // boucle pour créer 100 Reservations
        for ($i = 0; $i < 100; $i++) {
            $reservation = new Reservation();
            $reservation->setNombrePlaces($faker->numberBetween(1, 3))
                ->setSeance($faker->randomElement($seances))
                ->setStatut($faker->randomElement(Reservation::STATUTS_CONFIRMEE + Reservation::STATUTS_ANNULEE))
                ->setUtilisateur($faker->randomElement($utilisateurs));
            $manager->persist($reservation);
        }
        
        $manager->flush();
    }
}

