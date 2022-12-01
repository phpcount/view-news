<?php

namespace App\Utils\NewsParser\RBCNewsParser;

use App\Utils\NewsParser\AbstractPostListParser;
use App\Utils\NewsParser\DTO\PostItemDTO;
use App\Utils\NewsParser\DTO\PostListDTO;
use App\Utils\RatingGenerator;
use Symfony\Component\DomCrawler\Crawler;


class RBCPostListParser extends AbstractPostListParser
{
    public function __construct(int $maxNewsCount = null)
    {
        if ($maxNewsCount) {
            $this->maxNewsCount = $maxNewsCount;
        }

        $this->newsList = new PostListDTO();
    }

    protected function sourceUrl(): string
    {
        return 'https://www.rbc.ru/';
    }

    protected function listSelector(): string
    {
        return 'div.js-news-feed-list';
    }

    protected function itemSelector(): string
    {
        return 'a.news-feed__item'; // 'a.news-feed__item.js-news-feed-item'
    }

    protected function titleSelector(): string {
        return 'span.news-feed__item__title';
    }

    protected function parseItemId(string $str): string
    {
        preg_match('/^id_newsfeed_(?<id>.+)/', $str, $matches);
        if (empty($matches['id'])) {
            throw new \RuntimeException('Failed to correctly parse the original id');
        }

        return $matches['id'];
    }

    public function isValid(Crawler $crawler): bool
    {
        return boolval(
            $crawler->getNode(0)
        );
    }

    public function process()
    {
        $crawler = $this->parse((string)$this->getHTML($this->sourceUrl()));

        $crawler->filter($this->listSelector())
            ->each(function (Crawler $listNews, $i) {

            $listNews->filter($this->itemSelector())
                ->each(function (Crawler $itemNews, $i) {
                if ($i >= $this->maxNewsCount) {
                    return;
                }

                $newsItem = new PostItemDTO();
                $newsItem->setRating(RatingGenerator::get());
                if ($itemNews->nodeName() === 'a') {
                    $newsItem->setLink($itemNews->attr('href'));
                    $newsItem->setOriginalId($this->parseItemId($itemNews->attr('id')));
                }

                $titleElement = $itemNews->filter($this->titleSelector());
                if (1 === $titleElement->count()) {
                    $newsItem->setTitle($titleElement->text());
                }

                if ($newsItem->getTitle()) {
                    $newsItem->setCreatedAt(new \DateTimeImmutable());
                    $this->newsList->addItems($newsItem);
                }
            });
        });
    }

    public function handlePostItems(): void
    {
        foreach ($this->newsList->getItems() as $newsItem) {
            $postItemParser = new RBCPostItemParser($newsItem);
            $postItemParser->process();

            if (!$postItemParser->isValidProcess()) {
                $this->newsList->deleteItem($newsItem->getOriginalId());
            }
        }
    }

}
