<?php

namespace App\Utils\NewsParser;;

use Symfony\Contracts\Cache\CacheInterface;

class NewsCollectorConfig
{
    private const PARAM_DELAY_UPDATE = 'delay_news_update';

    private const PARAM_IN_PROCESS = 'in_process_news_update';

    public function __construct(private CacheInterface $cache)
    {
    }

    public function setDelayUpdate(int $value): int
    {
        return $this->setParam(self::PARAM_DELAY_UPDATE, $value);
    }

    public function getDelayUpdate(): int
    {
        return $this->getParam(self::PARAM_DELAY_UPDATE);
    }

    public function setStarted(bool $value): bool
    {
        return $this->setParam(self::PARAM_IN_PROCESS, $value);
    }

    public function isStarted(): bool
    {
        return $this->getParam(self::PARAM_IN_PROCESS, false);
    }


    private function getParam(string $param, mixed $default = 0): mixed
    {
        return $this->cache->get($param, fn () => $default);
    }

    private function setParam(string $key, mixed $value): mixed
    {
        $this->cache->delete($key);

        return $this->cache->get($key, function () use ($value) {
            return $value;
        });
    }
}
