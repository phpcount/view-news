<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Utils\NewsParser\DTO\PostListDTO;
use App\Utils\NewsParser\NewsCollectorFactory;

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

    public function mine(int $divisor = 3): void
    {
        $newsLimit = $this->newsLimit; // 5;

        $quotient = intval($newsLimit / $divisor);
        $remainder = $newsLimit % $divisor;
        $chunks = array_fill(0, $quotient, $divisor);
        if ($remainder) {
            array_push($chunks, $remainder);
        }

        $this->logger->debug('chunks', [$chunks]);

        foreach ($chunks as $count) {
            $this->logger->debug('count', [$count]);
            $newsCollector = NewsCollectorFactory::makeNews(NewsCollectorFactory::SOURCE_RBC, [$count]);
            $newsCollector->process();
            $newsCollector->filtredPostList($this->filterPostListService);
            $newsCollector->handlePostItems();

            $newsListDTO = $newsCollector->getData();

            $this->save($newsListDTO);
        }
    }

    public function save(PostListDTO $newsList): void
    {
        foreach ($newsList->getItems() as $newsItem) {
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
