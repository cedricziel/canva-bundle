<?php

namespace CedricZiel\CanvaBundle\Event\Content;

use Canva\Content\Request\FindRequest;
use Canva\Content\Response\ImageResponse;
use Canva\Request;
use Canva\Response;
use CedricZiel\CanvaBundle\Event\CanvaRequestEvent;

class FindRequestEvent extends CanvaRequestEvent
{
    /**
     * @var FindRequest
     */
    private FindRequest $request;

    /**
     * @var Response|null
     */
    private ?Response $response;

    /**
     * FindRequestEvent constructor.
     * @param FindRequest $request
     */
    public function __construct(FindRequest $request)
    {
        $this->request = $request;
    }

    public function getResponse(): Response
    {
        return $this->response ?? new ImageResponse();
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
