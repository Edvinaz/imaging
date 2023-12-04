<?php

namespace App\Controller;

use App\Service\ImagesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/upload', name: 'app_api_upload', methods: ['POST'])]
    public function index(Request $request, ImagesService $service): Response
    {
        $service->uploadImage($request->files->all(), $this->getParameter('upload_directory'));

        return $this->json(['OK']);
    }
}
