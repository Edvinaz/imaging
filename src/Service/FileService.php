<?php

namespace App\Service;

use Gaufrette\Adapter\Local;
use Gaufrette\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    private $adapter;
    private $filesystem;

    public function __construct(
        string $uploadDirectory
    ) {
        $this->adapter = new Local($uploadDirectory);
        $this->filesystem = new Filesystem($this->adapter);
    }

    public function saveUploadedImage(UploadedFile $uploadedFile, string $fileName)
    {
        $this->filesystem->write($fileName, $uploadedFile->getContent());
    }
}
