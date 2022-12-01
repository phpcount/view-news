<?php

namespace App\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends RuntimeException implements ApiExceptionInterface
{
    public function __construct(private ConstraintViolationListInterface $violation)
    {
        parent::__construct("validation failed", 400);
    }

    public function getViolation(): ConstraintViolationListInterface
    {
        return $this->violation;
    }
}
