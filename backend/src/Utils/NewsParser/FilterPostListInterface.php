<?php

namespace App\Utils\NewsParser;

use App\Utils\NewsParser\DTO\PostListDTO;

interface FilterPostListInterface
{
    public function filtredExistsPostIdsByOriginalIds(PostListDTO $newsList): PostListDTO;
}
