<?php

namespace App\Utils\NewsParser\DTO;

use Countable;

class PostListDTO implements Countable
{
    /**
     * @var PostItemDTO[]
     */
    private array $items = [];

    public function count(): int
    {
        return count($this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItems(PostItemDTO $item): void
    {
        $this->items[$item->getOriginalId()] = $item;
    }

    public function hasItem(string $id): bool
    {
        return isset($this->items[$id]);
    }

    public function deleteItem(string $id): void
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
        }
    }
}
