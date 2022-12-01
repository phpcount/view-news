<?php

namespace App\Exception;

interface ApiExceptionInterface
{
    public function getCode();

    public function getMessage(): string;
}
