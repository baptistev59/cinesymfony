<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
