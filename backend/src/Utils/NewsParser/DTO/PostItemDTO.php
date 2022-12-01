<?php

namespace App\Utils\NewsParser\DTO;

class PostItemDTO
{
    private string $title;

    private ?string $text_overview = null;

    private ?string $image = null;

    private string $content = '';

    private \DateTimeImmutable $created_at;

    private int $rating;

    private string $original_id;

    private string $link;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = trim($title);

        return $this;
    }

    public function getTextOverview(): ?string
    {
        return $this->text_overview;
    }

    public function setTextOverview(?string $text_overview): self
    {
        $this->text_overview = $text_overview;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getOriginalId(): string
    {
        return $this->original_id;
    }

    public function setOriginalId(string $original_id): self
    {
        $this->original_id = $original_id;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
