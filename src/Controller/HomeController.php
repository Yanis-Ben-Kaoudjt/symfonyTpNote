<?php

namespace App\Controller;

use App\Repository\ChapitreRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ExerciceRepository;
use App\Repository\MatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('home', name: 'app_home')]
    public function index(MatiereRepository $matiereRepository, ChapitreRepository $chapitreRepository,
    ExerciceRepository $exerciceRepository, CommentaireRepository $commentaireRepository): Response
    {
        $user = $this->getUser();
        if (!($user && $user->isBanned())) {
            $matieres = $matiereRepository->findAll();
            $chapitres = $chapitreRepository->findAll();
            $exercices = $exerciceRepository->findAll();
            $commentaires = $commentaireRepository->findAll();
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'matieres' => $matieres,
                'chapitres' => $chapitres,
                'exercices' => $exercices,
                'commentaires' => $commentaires,
                'user' => $user
            ]);
        }else{
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
    }
}
