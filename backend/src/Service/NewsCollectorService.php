<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Utils\NewsParser\DTO\PostListDTO;

use Psr\Log\LoggerInterface;

class NewsCollectorService
{
    public function __construct(
        private PostRepository $postRepository,
        private FilterPostListService $filterPostListService,
        private int $newsLimit,
        private LoggerInterface $logger
    ) {
    }

    public function save(PostListDTO $newsList): void
    {
        $newsItems = $newsList->getItems();

        usort($newsItems, function($a, $b) {
            $aDt = $a->getCreatedAt();
            $bDt = $b->getCreatedAt();

            if ($aDt == $bDt) {
                return 0;
            }

            return $aDt < $bDt ? -1 : 1;
        });

        foreach ($newsItems as $newsItem) {
            $post = new Post();
            $post
                ->setOriginalId($newsItem->getOriginalId())
                ->setTitle($newsItem->getTitle())
                ->setCreatedAt($newsItem->getCreatedAt())
                ->setTextOverview($newsItem->getTextOverview())
                ->setImage($newsItem->getImage())
                ->setContent($newsItem->getContent())
                ->setRating($newsItem->getRating())
                ->setLink($newsItem->getLink());

            $this->postRepository->save($post);
        }

        $this->postRepository->commit();
    }
}
