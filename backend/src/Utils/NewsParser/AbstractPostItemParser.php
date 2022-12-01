<?php

namespace App\Utils\NewsParser;

use App\Utils\NewsParser\DTO\PostItemDTO;

abstract class AbstractPostItemParser extends AbstractParser
{
    protected $isValidProcess = false;

    public function __construct(protected PostItemDTO $itemModel)
    {
    }

    protected function getData(): PostItemDTO
    {
        return $this->itemModel;
    }

    protected function getUri()
    {
        $uri = parse_url($this->itemModel->getLink());

        return $uri['scheme'] . '://'. $uri['host'];
    }

    public function isValidProcess(): bool
    {
        return $this->isValidProcess;
    }
}
