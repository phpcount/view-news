<?php

namespace App\Exception;

use RuntimeException;
use Throwable;

class RequestBodyConvertException extends RuntimeException implements ApiExceptionInterface
{
    public function __construct(Throwable $previous)
    {
        parent::__construct("error while unmarshalling request body", 400, $previous);
    }
}
