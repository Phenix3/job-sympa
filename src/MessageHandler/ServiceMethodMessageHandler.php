<?php

namespace App\MessageHandler;

use App\Message\ServiceMethodMessage;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final class ServiceMethodMessageHandler
{
    public function __construct(private readonly ContainerInterface $parameterBag)
    {}

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ServiceMethodMessage $message)
    {
        $service = $this->parameterBag->get($message->getServiceName());
        dump($service);
        $callable = [
            $service,
            $message->getMethod()
        ];

        call_user_func_array($callable, $message->getParams());
    }
}
