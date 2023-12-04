<?php

namespace App\Controller;

use App\Form\ImageUploadType;
use App\Service\ImagesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, ImagesService $service): Response
    {
        $images = $service->getImages();
        return $this->render('main.html.twig', [
            'user' => $this->getUser(),
            'images' => $images,
        ]);
    }

    #[Route('/imageUpload', name: 'app_images_upload')]
    public function uploadImages(Request $request, ImagesService $service): Response
    {
        $form = $this->createForm(ImageUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->uploadImage($form->getData(), $this->getParameter('upload_directory'));
        }

        return $this->render('images/upload.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
}
