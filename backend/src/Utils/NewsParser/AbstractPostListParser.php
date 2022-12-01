<?php

namespace App\Utils\NewsParser;

use App\Utils\NewsParser\DTO\PostListDTO;

abstract class AbstractPostListParser extends AbstractParser
{
    protected int $maxNewsCount = 15;

    protected PostListDTO $newsList;

    abstract protected function sourceUrl(): string;

    abstract protected function titleSelector(): string;

    abstract protected function listSelector(): string;

    abstract protected function itemSelector(): string;

    abstract protected function parseItemId(string $link): ?string;

    public function filtredPostList(FilterPostListInterface $filterPostListInterface): void
    {
        $this->newsList = $filterPostListInterface->filtredExistsPostIdsByOriginalIds($this->newsList);
    }

    abstract public function handlePostItems(): void;

    public function getData(): PostListDTO
    {
        return $this->newsList;
    }
}
