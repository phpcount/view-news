<?php

namespace App\Utils\NewsParser\RBCNewsParser\SelectorsStrategy;

class TvPostItem  implements PostItemSelectorsStrategyInterface
{
    public function titleSelector(): string
    {
        return 'h1.video-block__header__category';
    }

    public function createAtSelector(): ?string
    {
        return null;
    }

    public function textOverviewSelector(): ?string
    {
        return '.video-block__title';
    }

    public function imageSelector(): ?string
    {
        return null;
    }

    public function contentSelector(): string
    {
        return '.video-block__anons';
    }
}
