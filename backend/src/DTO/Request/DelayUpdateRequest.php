<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints\{GreaterThan, NotBlank};

class DelayUpdateRequest
{
    #[NotBlank]
    #[GreaterThan(-1)]
    private int $delay;

    public function getDelay(): int
    {
        return $this->delay;
    }

    public function setDelay(int $delay): self
    {
        $this->delay = $delay;

        return $this;
    }
}
