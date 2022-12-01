<?php

namespace App\Service;

use App\Repository\PostRepository;
use App\Utils\NewsParser\DTO\{PostListDTO, PostItemDTO};
use App\Utils\NewsParser\FilterPostListInterface;

class FilterPostListService implements FilterPostListInterface
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    public function filtredExistsPostIdsByOriginalIds(PostListDTO $newsList): PostListDTO
    {
        $allIds = array_map(function (PostItemDTO $item) {
            return $item->getOriginalId();
        }, $newsList->getItems());

        $existsIds = $this->postRepository->findPostIdsByOriginalIds($allIds);
        foreach ($existsIds as $existsId) {
            if ($newsList->hasItem($existsId)) {
                $newsList->deleteItem($existsId);
            }
        }

        return $newsList;
    }
}
