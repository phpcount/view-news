<?php

namespace App\Utils\NewsParser\RBCNewsParser\SelectorsStrategy;

class SmartwayPostItem  implements PostItemSelectorsStrategyInterface
{
    public function titleSelector(): string
    {
        return 'h1.article__title';
    }

    public function createAtSelector(): ?string
    {
        return null;
    }

    public function textOverviewSelector(): ?string
    {
        return null;
    }

    public function imageSelector(): ?string
    {
        return 'div.article__image--main img';
    }

    public function contentSelector(): string
    {
        return 'div.article__text';
    }
}
