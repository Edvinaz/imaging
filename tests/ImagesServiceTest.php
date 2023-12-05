<?php

namespace App\Tests;

use App\Entity\Image;
use App\Entity\User;
use App\Service\FileService;
use App\Service\ImagesService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class ImagesServiceTest extends TestCase
{
    public function testCorrectImageItemCreated(): void
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('guessExtension')->willReturn('jpg');

        $user = $this->createMock(User::class);

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn($this->createMockTokenWithUser($user));

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Image::class));

        $entityManager->expects($this->once())
            ->method('flush');

        $fileService = $this->createMock(FileService::class);
        $fileService->expects($this->once())
            ->method('saveUploadedImage')
            ->with($file);

        $service = new ImagesService(
            $tokenStorage,
            $entityManager,
            $fileService
        );

        $image = $service->uploadImage($file);

        $this->assertInstanceOf(Image::class, $image);
        $this->assertSame($user, $image->getUser());
    }

    private function createMockTokenWithUser($user)
    {
        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($user);

        return $token;
    }
}
