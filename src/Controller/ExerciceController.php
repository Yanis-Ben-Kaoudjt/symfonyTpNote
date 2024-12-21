<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use App\Repository\ExerciceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exercice')]
final class ExerciceController extends AbstractController
{
    #[Route(name: 'app_exercice_index', methods: ['GET'])]
    public function index(ExerciceRepository $exerciceRepository): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        return $this->render('exercice/index.html.twig', [
            'exercices' => $exerciceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_exercice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exercice);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercice/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercice_show', methods: ['GET'])]
    public function show(Exercice $exercice): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        return $this->render('exercice/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exercice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercice/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercice_delete', methods: ['POST'])]
    public function delete(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $exercice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($exercice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
    }
}
