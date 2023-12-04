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
    #[Route('/images', name: 'app_images')]
    public function index(): Response
    {
        dd($this->getUser());
        return $this->render('images/index.html.twig', [
            'controller_name' => 'ImagesController',
        ]);
    }

    #[Route('/imageUpload', name: 'app_images_upload')]
    public function uploadImages(Request $request, ImagesService $service): Response
    {
        $form = $this->createForm(ImageUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $user = $this->getUser();
//            dump('test');
//            dd($user);
            $service->uploadImage($form->getData(), $this->getParameter('upload_directory'));
        }

        return $this->render('images/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
