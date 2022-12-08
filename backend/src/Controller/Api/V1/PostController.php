<?php

namespace App\Controller\Api\V1;

use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/v1/post', name: 'app_post_')]
class PostController extends AbstractController
{
    public function __construct(private PostService $postService)
    {
    }

    #[Route('', methods: ['GET'], name: 'all')]
    public function all(int $limit, Request $request): JsonResponse
    {
        $firstPk = $request->query->getInt('first_pk', 0);
        $lastPk = $request->query->getInt('last_pk', 0);
        $limit = $request->query->getInt('limit', $limit);

        if ($firstPk !== 0) {
            return $this->json($this->postService->allByScroll($firstPk, $limit));
        }

        if ($lastPk !== 0) {
            return $this->json($this->postService->allByLongPolling($lastPk, $limit));
        }

        return $this->json($this->postService->all($limit));
    }

    #[Route('/{id}', methods: ['GET'], name: 'get')]
    public function get(string $id): JsonResponse
    {
        return $this->json($this->postService->get($id));
    }

    #[Route('/{id}', methods: ['DELETE'], name: 'delete')]
    public function delete(string $id): JsonResponse
    {
        $this->postService->delete($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
