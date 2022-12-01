<?php

namespace App\DTO\Response;

trait LinksTrait
{
    private Links $links;

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
