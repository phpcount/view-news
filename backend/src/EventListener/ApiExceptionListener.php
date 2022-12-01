<?php

namespace App\EventListener;

use App\DTO\Response\ErrorResponse;
use App\DTO\Response\ViolationResponse;
use App\Exception\ApiExceptionInterface;
use App\Exception\ValidationException;
use App\Service\ExceptionHandler\ExceptionMapping;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class ApiExceptionListener
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        if (! ($throwable instanceof ApiExceptionInterface)) {
            return;
        }

        $message = $throwable->getMessage();
        $code = $throwable->getCode();

        $modelResponse = new ErrorResponse(
            $message
        );

        if ($throwable instanceof ValidationException) {
            $violations = '';
            foreach ($throwable->getViolation() as $violation) {
                $violations .= $violation->getMessage() . ', ';
            }

            $violations = substr($violations, 0, -2);

            $modelResponse = new ViolationResponse(
                $message,
                $violations
            );
        }

        $data = $this->serializer->serialize($modelResponse, JsonEncoder::FORMAT);

        $event->setResponse(new JsonResponse($data, $code, [], true));
    }

}
