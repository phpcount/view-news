<?php

namespace App\Utils\NewsParser\RBCNewsParser;

use App\Utils\NewsParser\AbstractPostItemParser;
use App\Utils\NewsParser\RBCNewsParser\SelectorsModel\NewsItemSelectorsModelInterface;
use DateTimeImmutable;
use Symfony\Component\DomCrawler\Crawler;

class RBCPostItemParser extends AbstractPostItemParser
{
    public function isValid(Crawler $crawler): bool
    {
        return boolval($this->itemModel->getLink());
    }

    public function process()
    {
        $crawler = $this->parse($this->getHTML($this->itemModel->getLink()));

        $newsSelectorsStrategies = [
            fn () => new SelectorsStrategy\DefaultPostItem(),
            fn () => new SelectorsStrategy\SmartwayPostItem(),
            fn () => new SelectorsStrategy\StylePostItem(),
            fn () => new SelectorsStrategy\Domrf25PostItem(),
            fn () => new SelectorsStrategy\LifePostItem(),
            fn () => new SelectorsStrategy\EsgSberWorldPostItem(),
            fn () => new SelectorsStrategy\TvPostItem(),
            fn () => new SelectorsStrategy\ProPostItem(),
        ];

        foreach ($newsSelectorsStrategies as $newsItemSelectorsClosure) {
            /** @var Model\NewsItemSelectorsModelInterface $newsItemSelectors */
            $newsItemSelectors = $newsItemSelectorsClosure->call($this);

            // var_dump('Current link: ' . $this->itemModel->getLink()) . PHP_EOL;
            // var_dump('Current strategy: ' . $newsItemSelectors::class) . PHP_EOL;

            $titleNode = $crawler->filter($newsItemSelectors->titleSelector());
            $contentNodes = $crawler->filter($newsItemSelectors->contentSelector());
            if (0 === $titleNode->count() || 0 ===  $contentNodes->count()) {
                // trying other selectors
                continue;
            }

            $this->itemModel->setTitle($titleNode->text());

            if (null !== $newsItemSelectors->createAtSelector()) {
                $nodeCreateAt = $crawler->filter($newsItemSelectors->createAtSelector());
                if ($nodeCreateAt->count() > 0) {
                    try {
                        $time = new DateTimeImmutable($nodeCreateAt->attr('content'));
                        $this->itemModel->setCreatedAt($time);
                    } catch (\Throwable $th) {
                        // need warning
                        //     throw $th;
                    }
                }
            }

            $textOverviewSelector = $newsItemSelectors->textOverviewSelector();
            if ($textOverviewSelector) {
                $nodeTextOverview = $crawler->filter($textOverviewSelector);
                if ($nodeTextOverview->count() > 0) {
                    $this->itemModel->setTextOverview($nodeTextOverview->text());
                }
            }

            $imageSelector = $newsItemSelectors->imageSelector();
            if ($imageSelector) {
                $nodeImage = $crawler->filter($imageSelector);
                if ($nodeImage->count() > 0) {
                    $nodeImage = new Crawler($nodeImage->getNode(0), $this->getUri());
                    $this->itemModel->setImage($nodeImage->image()->getUri());
                }
            }

            $text = '';
            foreach ($contentNodes->getIterator() as $content) {
                $text .= preg_replace("/\s{3,}/", "", $content->textContent) . "\n";
            }

            $this->itemModel->setContent($text);

            if ($this->isValidProcess = $this->itemModel->getTitle() && $this->itemModel->getContent()) {
                break;
            }
        }
    }
}
