<?php

namespace App\Utils\NewsParser\RBCNewsParser\SelectorsStrategy;

class DefaultPostItem implements PostItemSelectorsStrategyInterface
{
/*
<div class="article g-relative js-rbcslider-article ">
    div article__header js-article-header
        <a href="https://sportrbc.ru/football/" class="article__header__category" itemprop="articleSection" content="Футбол">Футбол</a>
        <time class="article__header__date" datetime="2022-11-24T18:05:22+03:00" itemprop="datePublished" content="2022-11-24T18:05:22+03:00">24 ноя, 18:05</time>

        <h1 class="article__header__title-in js-slide-title" itemprop="headline">
    <div class="article__text article__text_free" itemprop="articleBody">
        <div class="article__text__overview">
        <div class="article__main-image" itemscope="" itemtype="http://schema.org/ImageObject">
            <img

*/

    public function titleSelector(): string
    {
        return 'h1[itemprop="headline"]'; // h1.article__header__title-in
    }

    public function createAtSelector(): ?string
    {
        return '[itemprop="datePublished"]';
    }

    public function textOverviewSelector(): ?string
    {
        return 'div.article__text__overview';
    }

    public function imageSelector(): ?string
    {
        return 'div.article__main-image img';
    }

    public function contentSelector(): string
    {
        return 'div.article__text';
    }
}
