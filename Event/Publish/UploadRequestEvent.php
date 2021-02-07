<?php

namespace CedricZiel\CanvaBundle\Event\Publish;

use Canva\Publish\Request\UploadRequest;
use Canva\Publish\Response\UploadResponse;
use Canva\Request;
use Canva\Response;
use CedricZiel\CanvaBundle\Event\CanvaRequestEvent;

final class UploadRequestEvent extends CanvaRequestEvent
{
    /**
     * @var UploadRequest
     */
    private UploadRequest $request;

    private ?Response $response;

    public function __construct(UploadRequest $uploadRequest)
    {
        $this->request = $uploadRequest;
    }

    public function getResponse(): Response
    {
        return $this->response ?? new UploadResponse();
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
