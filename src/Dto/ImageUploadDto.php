<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ImageUploadDto
{
    private Assert\File $image;

}
