<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main.html.twig', [
        ]);
    }

    #[Route('/home', name: 'app_user_home')]
    public function userHome(): Response
    {
        return $this->render('home.html.twig', [
        ]);
    }

    #[Route('/home/profile', name: 'app_user_profile')]
    public function userProfile(): Response
    {
        return $this->render('profile.html.twig', [
        ]);
    }
}
