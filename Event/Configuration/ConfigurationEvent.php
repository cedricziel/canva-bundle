<?php

namespace CedricZiel\CanvaBundle\Event\Configuration;

use Canva\Configuration\Request\ConfigurationRequest;
use Canva\Configuration\Response\ConfigurationSuccessResponse;
use Canva\Request;
use Canva\Response;
use CedricZiel\CanvaBundle\Event\CanvaRequestEvent;

class ConfigurationEvent extends CanvaRequestEvent
{
    /**
     * @var ConfigurationRequest
     */
    private ConfigurationRequest $request;

    private ?Response $response;

    public function __construct(ConfigurationRequest $request)
    {
        $this->request = $request;
    }

    public function getResponse(): Response
    {
        return $this->response ?? new ConfigurationSuccessResponse();
    }

    public function setResponse(?Response $response): CanvaRequestEvent
    {
        $this->response = $response;

        return $this;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
