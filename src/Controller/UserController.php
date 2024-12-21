<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!($user && !$user->isBanned())) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
