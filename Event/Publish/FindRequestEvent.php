<?php

namespace CedricZiel\CanvaBundle\Event\Publish;

use Canva\Publish\Request\FindRequest;
use Canva\Publish\Response\FindResponse;
use Canva\Request;
use Canva\Response;
use CedricZiel\CanvaBundle\Event\CanvaRequestEvent;

final class FindRequestEvent extends CanvaRequestEvent
{
    /**
     * @var FindRequest
     */
    private FindRequest $request;

    private ?Response $response;

    public function __construct(FindRequest $request)
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
