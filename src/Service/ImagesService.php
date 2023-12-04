<?php

namespace App\Service;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ImagesService
{
    public function __construct(
        private TokenStorageInterface  $tokenStorage,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getImages(): array
    {
        $list = $this->entityManager->getRepository(Image::class)->findAll();

        return $list;
    }

    public function uploadImage(array $data, string $uploadDirectory): void
    {
        $token = $this->tokenStorage->getToken();

        $user = $token->getUser();
        $uploadedFile = $data['image'];
        $newFileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();

        $image = new Image();
        $image->setUser($user);
        $image->setPath($newFileName);

        $uploadedFile->move($uploadDirectory, $newFileName);

        $this->entityManager->persist($image);
        $this->entityManager->flush();
    }
}
