<?php

namespace App\Controller\Api\V1;

use App\Attribute\RequestBody;
use App\DTO\Request\PostRatingUpdateRequest;
use App\Service\PostRatingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/v1/post', name: 'app_post_rating_')]
class PostRatingController extends AbstractController
{
    public function __construct(private PostRatingService $postRatingService)
    {
    }

    #[Route('/{id}/rating', methods: 'POST', name: 'update')]
    public function update(string $id, #[RequestBody] PostRatingUpdateRequest $request): JsonResponse
    {
        $this->postRatingService->update($id, $request);

        return $this->json(null);
    }
}
