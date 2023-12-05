<?php

namespace App\Controller;

use App\Request\ImageRequest;
use App\Service\ImagesService;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @OA\Parameter(
     *     name="image",
     *     in="query",
     *     description="Attach upload file",
     *     required=true
     *     )
     *  @Security(name="Bearer")
      */
    #[Route('/api/upload', name: 'app_api_upload', methods: ['POST'])]
    public function index(ImageRequest $request, ImagesService $service): Response
    {
        $file = $request->getRequest()->files->get('image');

        $uploadedImage = $service->uploadImage($file);

        return $this->json(['image_uploaded' => $uploadedImage->getPath()]);
    }
}
