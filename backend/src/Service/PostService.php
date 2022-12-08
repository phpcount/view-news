<?php

namespace App\Service;

use App\DTO\Response\{PostItemResponse, PostListItem, PostListResponse, SuccessRespone};
use App\Entity\Post;
use App\Repository\PostRepository;

class PostService
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    public function all(int $limit): SuccessRespone
    {
        $posts = $this->postRepository->findAllSortedByIdDesc($limit);

        return $this->allMapResult($posts);
    }

    public function allByLongPolling(int $lastPk, int $limit): SuccessRespone
    {
        $posts = $this->postRepository->findAllSortedByLastId($lastPk, $limit);

        $posts = array_reverse($posts);

        return $this->allMapResult($posts);
    }

    public function allByScroll(int $firstPk, int $limit): SuccessRespone
    {
        $posts = $this->postRepository->findAllSortedByFirstId($firstPk, $limit);

        return $this->allMapResult($posts);
    }

    private function allMapResult(array $posts): SuccessRespone
    {
        $posts = array_map(function (Post $post) {
            return (new PostListItem())
                ->setPk($post->getId())
                ->setId($post->getOriginalId())
                ->setTitle($post->getTitle())
                ->setCreatedAt($post->getCreatedAt())
                ->setContent($post->getContent())
                ->setRating($post->getRating());
        }, $posts);

        return new SuccessRespone(new PostListResponse($posts));
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
