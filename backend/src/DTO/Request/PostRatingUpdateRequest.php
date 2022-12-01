<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints\{GreaterThan, NotBlank, LessThanOrEqual};

class PostRatingUpdateRequest
{
    #[NotBlank]
    #[LessThanOrEqual(10)]
    #[GreaterThan(0)]
    private int $rating;

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
