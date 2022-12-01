<?php

namespace App\Utils\NewsParser\RBCNewsParser\SelectorsStrategy;

class EsgSberWorldPostItem  implements PostItemSelectorsStrategyInterface
{
    public function titleSelector(): string
    {
        return 'div.article__title';
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
        return null;
    }

    public function contentSelector(): string
    {
        // .article__text > 1
        return 'div.article__text';
    }
}
