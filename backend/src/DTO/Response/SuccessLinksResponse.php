<?php

namespace App\DTO\Response;

use App\DTO\Response\SuccessRespone;

class SuccessLinksResponse extends SuccessRespone
{
    public function __construct(private mixed $data, private Links $links)
    {
        parent::__construct($data);
    }

    public function getLinks(): Links
    {
        return $this->links;
    }

    public function setLinks(Links $links): self
    {
        $this->links = $links;

        return $this;
    }
}
