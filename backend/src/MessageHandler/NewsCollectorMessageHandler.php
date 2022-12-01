<?php

namespace App\MessageHandler;

use App\Message\NewsCollectorMessage;
use App\Service\NewsCollectorService;
use App\Utils\NewsParser\NewsCollectorConfig;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewsCollectorMessageHandler implements MessageHandlerInterface
{

    public function __construct(
        private NewsCollectorService $collectorService,
        private NewsCollectorConfig $config,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(NewsCollectorMessage $message): void
    {
        $this->logger->debug('--start--');

        $this->config->setStarted($message->isStarted());

        while ($this->config->isStarted()) {
            $delayNewsUpdate = $this->config->getDelayUpdate();
            sleep($delayNewsUpdate);

            $this->collectorService->mine();
        }

        $this->config->setStarted(false);
        $this->logger->debug('--stop--');
    }
}
