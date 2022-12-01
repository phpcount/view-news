<?php

namespace App\Service;

use App\DTO\Response\{Links, PostItemResponse, PostListItem, PostListResponse, SuccessLinksResponse, SuccessRespone};
use App\Entity\Post;
use App\Repository\PostRepository;

class PostService
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    public function all(string $link, int $page, int $limit): SuccessLinksResponse
    {
        if ($page < 1) {
            $page = 1;
        }

        $paginator = $this->postRepository->findAllSortedDateAndRatingAndPaginator($page, $limit);
        $totalElements = count($paginator);

        $posts = [];
        foreach ($paginator as $_page) {
            $posts[] = $_page;
        }

        $posts = array_map(function (Post $post) {
            return (new PostListItem())
                ->setId($post->getOriginalId())
                ->setTitle($post->getTitle())
                ->setCreatedAt($post->getCreatedAt())
                ->setContent($post->getContent())
                ->setRating($post->getRating());
        }, $posts);

        return new SuccessLinksResponse(new PostListResponse($posts), new Links(
            $link,
            $limit,
            $page,
            $totalElements
        ));
    }

    public function get(string $originalId): SuccessRespone
    {
        $post = $this->postRepository->findByOriginalId($originalId);

        $postItemResponse = (new PostItemResponse())
            ->setId($post->getOriginalId())
            ->setTitle($post->getTitle())
            ->setTextOverview($post->getTextOverview())
            ->setCreatedAt($post->getCreatedAt())
            ->setContent($post->getContent())
            ->setRating($post->getRating())
            ->setLink($post->getLink())
            ->setImage($post->getImage());

        return new SuccessRespone($postItemResponse);
    }

    public function delete(string $originalId): void
    {
        $post = $this->postRepository->findByOriginalId($originalId);

        $this->postRepository->remove($post, true);
    }
}
