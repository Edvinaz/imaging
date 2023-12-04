<?php

namespace App\Controller;

use App\Service\ImagesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, ImagesService $service): Response
    {
        $images = $service->getImages();
        return $this->render('main.html.twig', [
            'images' => $images,
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
