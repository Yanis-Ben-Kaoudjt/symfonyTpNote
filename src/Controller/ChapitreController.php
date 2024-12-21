<?php

namespace App\Controller;

use App\Entity\Chapitre;
use App\Form\ChapitreType;
use App\Repository\ChapitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChapitreController extends AbstractController
{
    #[Route('/chapitre', name: 'app_chapitre_index', methods: ['GET'])]
    public function index(ChapitreRepository $chapitreRepository): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        return $this->render('chapitre/index.html.twig', [
            'chapitres' => $chapitreRepository->findAll(),
        ]);
    }

    #[Route('/chapitre/new', name: 'app_chapitre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        $chapitre = new Chapitre();
        $form = $this->createForm(ChapitreType::class, $chapitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chapitre);
            $entityManager->flush();

            return $this->redirectToRoute('app_chapitre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chapitre/new.html.twig', [
            'chapitre' => $chapitre,
            'form' => $form,
        ]);
    }

    #[Route('/chapitre/{id}', name: 'app_chapitre_show', methods: ['GET'])]
    public function show(Chapitre $chapitre): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        return $this->render('chapitre/show.html.twig', [
            'chapitre' => $chapitre,
        ]);
    }

    #[Route('/chapitre/{id}/edit', name: 'app_chapitre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chapitre $chapitre, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(ChapitreType::class, $chapitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chapitre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chapitre/edit.html.twig', [
            'chapitre' => $chapitre,
            'form' => $form,
        ]);
    }

    #[Route('/chapitre/{id}', name: 'app_chapitre_delete', methods: ['POST'])]
    public function delete(Request $request, Chapitre $chapitre, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $chapitre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($chapitre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chapitre_index', [], Response::HTTP_SEE_OTHER);
    }
}
