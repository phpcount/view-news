<?php

namespace App\Exception;

use RuntimeException;

class PostNotFoundException extends RuntimeException implements ApiExceptionInterface
{
    public function __construct()
    {
        parent::__construct("post not found", 404);
    }
}
