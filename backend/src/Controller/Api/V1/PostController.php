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
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', $limit);

        // fix: a need domain from config
        $link = $this->generateUrl('app_post_all');

        return $this->json($this->postService->all($link, $page, $limit));
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
