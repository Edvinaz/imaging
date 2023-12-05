<?php

namespace App\Controller;

use App\Service\ImagesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Security;

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
    public function index(Request $request, ImagesService $service): Response
    {
        $validator = Validation::createValidator();
        $constraints = [
            new Assert\File([
                'maxSize' => '5M',
                'mimeTypes' => ['image/jpeg', 'image/png'],
                'mimeTypesMessage' => 'Please upload a valid JPG or PNG image.',
            ]),
        ];
        $file = $request->files->get('image');
        $errors = $validator->validate($file, $constraints);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return $this->json(['error' => $errorMessages], 400);
        }
        $uploadedImage = $service->uploadImage($request->files->get('image'));

        return $this->json(['image_uploaded' => $uploadedImage->getPath()]);
    }
}
