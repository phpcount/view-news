<?php

namespace App\Controller\Api\V1;

use App\Attribute\RequestBody;
use App\DTO\Request\DelayUpdateRequest;
use App\Message\NewsCollectorMessage;
use App\Utils\NewsParser\NewsCollectorConfig;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api/v1/news/collector', name: 'app_api_v1_news_collector_')]
class NewsCollectorController extends AbstractController
{
    public function __construct(private NewsCollectorConfig $config)
    {
    }

    #[Route('/start', name: 'start')]
    public function start(Request $request, MessageBusInterface $bus): JsonResponse
    {
        $delay = $request->query->getInt('delay', 0);

        $this->config->setDelayUpdate($delay);

        usleep(100000);
        if (false === $this->config->isStarted()) {
            $bus->dispatch(new NewsCollectorMessage(true));
        }

        return $this->json(null);
    }

    #[Route('/stop', name: 'stop')]
    public function stop(): JsonResponse
    {
        $this->config->setStarted(false);

        return $this->json(null);
    }

    #[Route('/state', name: 'state')]
    public function state(): JsonResponse
    {
        return $this->json($this->config->isStarted());
    }

    #[Route('/delay', methods: 'POST', name: 'delay')]
    public function changeDelay(#[RequestBody] DelayUpdateRequest $delayUpdateRequest): JsonResponse
    {
        $this->config->setDelayUpdate($delayUpdateRequest->getDelay());

        return $this->json(null);
    }
}
