<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ImageUploadValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ImageUpload) {
            throw new UnexpectedTypeException($constraint, ImageUpload::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $allowedFormats = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedFormats, true)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
