<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commentaire')]
final class CommentaireController extends AbstractController
{
    #[Route(name: 'app_commentaire_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_show', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté et s'il a le rôle ROLE_ADMIN
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur n'est pas connecté ou n'a pas le rôle ROLE_ADMIN, rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $commentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
