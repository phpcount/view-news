<?php

namespace App\DTO\Response;

class Links
{
    private string $self;

    private string $next;

    private string $last;

    public function __construct(
        string $link,
        int $limit,
        int $currentPage,
        int $totalElements
    ) {
        $this->self = $link . '?page=' . $currentPage;
        $lastPage = $this->calcLastPage($totalElements, $limit);

        $this->next = $link . '?page=' . min($currentPage + 1, $lastPage);
        $this->last = $link . '?page=' . $lastPage;
    }

    private function calcLastPage(int $totalElements, int $limit): int
    {
        return (int)ceil($totalElements / $limit);
    }

    public function getSelf(): string
    {
        return $this->self;
    }

    public function getNext(): string
    {
        return $this->next;
    }

    public function getLast(): string
    {
        return $this->last;
    }
}
