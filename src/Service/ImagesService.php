<?php

namespace App\Service;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ImagesService
{
    public function __construct(
        private TokenStorageInterface  $tokenStorage,
        private EntityManagerInterface $entityManager,
        private FileService $fileService
    ) {
    }

    public function getImages(int $limit = 16, int $page = 0): array
    {
        $list = $this->entityManager->getRepository(Image::class)->getPaginatedImages($page, $limit);

        return $list;
    }

    public function uploadImage(UploadedFile $uploadedFile, string $uploadDirectory)
    {
        $token = $this->tokenStorage->getToken();

        $user = $token->getUser();

        $newFileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();

        $image = new Image();
        $image->setUser($user);
        $image->setPath($newFileName);

        $this->fileService->saveUploadedImage($uploadedFile, $newFileName);

        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $newFileName;
    }
}
