<?php

namespace App\Utils\NewsParser\RBCNewsParser\SelectorsStrategy;

class ProPostItem implements PostItemSelectorsStrategyInterface
{
    public function titleSelector(): string
    {
        return 'h1[itemprop="headline"]';
    }

    public function createAtSelector(): ?string
    {
        return '[itemprop="datePublished"]';
    }

    public function textOverviewSelector(): ?string
    {
        return 'div.article__text__overview';
    }

    public function imageSelector(): ?string
    {
        return 'div.article__main-image img';
    }

    public function contentSelector(): string
    {
        return 'div.article__text__pro';
    }
}
