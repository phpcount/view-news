<?php

namespace App\DTO\Response;

class SuccessRespone
{
    private bool $success = true;

    public function __construct(private mixed $data)
    {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }
}
