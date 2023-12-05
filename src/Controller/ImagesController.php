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
        $page = $request->get('page', 0);
        $limit = $request->get('limit', 12);
        $images = $service->getImages($limit, $page);
        $count = $service->getImagesCount()[1];

        return $this->render('main.html.twig', [
            'user' => $this->getUser(),
            'images' => $images,
            'page' => $page,
            'limit' => $limit,
            'count' => $count,
        ]);
    }

    #[Route('/imageUpload', name: 'app_images_upload')]
    public function uploadImages(Request $request, ImagesService $service): Response
    {
        $form = $this->createForm(ImageUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->uploadImage($form->getData()['image']);
        }

        return $this->render('images/upload.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
}
