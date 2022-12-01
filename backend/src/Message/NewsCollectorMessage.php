<?php

namespace App\Message;

class NewsCollectorMessage
{
    public function __construct(private bool $started)
    {
    }

    public function isStarted(): bool
    {
        return $this->started;
    }
}
