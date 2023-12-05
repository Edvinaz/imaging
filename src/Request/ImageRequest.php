<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

class ImageRequest extends BaseRequest
{
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/jpeg', 'image/png'],
        mimeTypesMessage: 'Please upload a valid JPG or PNG image.'
        )]
    #[NotBlank()]
    protected $image;
}
