<?php

namespace App\Utils\NewsParser\RBCNewsParser\SelectorsStrategy;

class StylePostItem implements PostItemSelectorsStrategyInterface
{
    public function titleSelector(): string
    {
        return 'h1.article__header';
    }

    public function createAtSelector(): string
    {
        return '[itemprop="datePublished"]';
    }

    public function textOverviewSelector(): ?string
    {
        return 'div.article__subtitle';
    }

    public function imageSelector(): ?string
    {
        return 'div.article__main-image__inner img';
    }

    public function contentSelector(): string
    {
        // .article__text > 1
        return 'div.article__text';
    }
}
