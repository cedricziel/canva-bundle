<?php

namespace CedricZiel\CanvaBundle\Event\Publish;

use Canva\Publish\Response\FindResponse;
use Canva\Publish\Request\GetResourceRequest;
use Canva\Request;
use Canva\Response;
use CedricZiel\CanvaBundle\Event\CanvaRequestEvent;

final class GetRequestEvent extends CanvaRequestEvent
{
    /**
     * @var GetResourceRequest
     */
    private GetResourceRequest $request;

    private ?Response $response;

    public function __construct(GetResourceRequest $request)
    {
        $this->request = $request;
    }

    public function getResponse(): Response
    {
        return $this->response ??  new FindResponse();
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
