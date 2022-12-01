<?php

namespace App\Utils\NewsParser;

use PhpParser\ErrorHandler;
use PhpParser\Parser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractParser implements Parser
{
    abstract public function process();

    abstract public function isValid(Crawler $crawler): bool;

    public function parse(string $code, ?ErrorHandler $errorHandler = null): Crawler
    {
        $crawler = new Crawler($code);

        if (false === $this->isValid($crawler)) {
            throw new \RuntimeException('not valid schema');
        }

        return $crawler;
    }

    protected function getHTML(string $url = null): string
    {
        $httpClient = HttpClient::create();
        $httpClient->withOptions([
            'timeout' => 5,
            'headers' => [
                'Accept' => 'text/html',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
                'Cache-Control' => 'max-age=0',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36'
            ]
        ]);

        $response = $httpClient->request('GET', $url);

        return $response->getContent();
    }
}
