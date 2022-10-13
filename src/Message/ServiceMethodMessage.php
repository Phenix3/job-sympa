<?php

namespace App\Message;

class ServiceMethodMessage
{
    public function __construct(private string $serviceName, private string $method, private array $params = [])
    {}

    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}