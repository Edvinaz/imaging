<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ImagesService
{
    public function __construct(
        private TokenStorageInterface  $tokenStorage,
        private EntityManagerInterface $entityManager,
        private FileService            $fileService
    )
    {
    }

    public function getImages(int $limit = 16, int $page = 0): array
    {
        return $this->entityManager->getRepository(Image::class)->getPaginatedImages($page, $limit);
    }

    public function getImagesCount()
    {
        return $this->entityManager->getRepository(Image::class)->getImageCount();
    }

    public function uploadImage(UploadedFile $uploadedFile): Image
    {
        $user = $this->getUser();
        $newFileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        $image = $this->saveImage($user, $newFileName);

        $this->fileService->saveUploadedImage($uploadedFile, $newFileName);

        return $image;
    }

    private function getUser(): User
    {
        $token = $this->tokenStorage->getToken();

        return $token->getUser();
    }

    private function saveImage(User $user, string $fileName): Image
    {
        $image = new Image();
        $image->setUser($user);
        $image->setPath($fileName);

        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $image;
    }
}
