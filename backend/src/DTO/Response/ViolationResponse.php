<?php

namespace App\DTO\Response;

class ViolationResponse
{
    private bool $success = false;

    public function __construct(private mixed $error, private mixed $violation)
    {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getError(): mixed
    {
        return $this->error;
    }

    public function setError($error): self
    {
        $this->error = $error;

        return $this;

    }

    public function getViolation(): mixed
    {
        return $this->violation;
    }
}
