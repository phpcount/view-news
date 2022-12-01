<?php

namespace App\Utils\NewsParser\RBCNewsParser\SelectorsStrategy;

class LifePostItem implements PostItemSelectorsStrategyInterface
{
    public function titleSelector(): string
    {
        return 'article .article-entry-title';
    }

    public function createAtSelector(): ?string
    {
        return '[itemprop="datePublished"]';
    }

    public function textOverviewSelector(): ?string
    {
        return '.article-entry-subtitle';
    }

    public function imageSelector(): ?string
    {
        return 'div.article-image img';
    }

    public function contentSelector(): string
    {
        return 'article p.paragraph';
    }
}
