<?php

namespace App\Utils\NewsParser\RBCNewsParser\SelectorsStrategy;

interface PostItemSelectorsStrategyInterface
{
    public function titleSelector(): string;

    public function createAtSelector(): ?string;

    public function textOverviewSelector(): ?string;

    public function imageSelector(): ?string;

    public function contentSelector(): string;
}
