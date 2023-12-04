<?php

namespace App\Service;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ImagesService
{
    public function __construct(
        private TokenStorageInterface  $tokenStorage,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function uploadImage(array $data, string $uploadDirectory)
    {
        $token = $this->tokenStorage->getToken();

        $user = $token->getUser();
        $uploadedFile = $data['image'];
        $newFileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();

        $image = new Image();
        $image->setUser($user);
        $image->setPath($newFileName);
        
        $this->entityManager->persist($image);
        $this->entityManager->flush();

        $uploadedFile->move(
            $uploadDirectory,
            $newFileName
        );
    }

}
