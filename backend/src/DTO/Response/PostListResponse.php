<?php

namespace App\DTO\Response;

class PostListResponse
{
    /**
     * @var PostListItem[] $items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @return PostListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param PostListItem[] $items
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
