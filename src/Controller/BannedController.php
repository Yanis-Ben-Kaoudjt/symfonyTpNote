<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BannedController extends AbstractController
{
    #[Route('/banned', name: 'app_banned')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!($user && $user->isBanned())) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('banned/index.html.twig', [
            'controller_name' => 'BannedController',
        ]);
    }
}
