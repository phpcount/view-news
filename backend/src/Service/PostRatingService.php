<?php

namespace App\Service;

use App\DTO\Request\PostRatingUpdateRequest;
use App\Repository\PostRepository;

class PostRatingService
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    public function update(string $originalId, PostRatingUpdateRequest $ratingUpdateRequest): void
    {
        $post = $this->postRepository->findByOriginalId($originalId);

        $post->setRating($ratingUpdateRequest->getRating());

        $this->postRepository->commit();
    }
}
