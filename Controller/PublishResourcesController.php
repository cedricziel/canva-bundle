<?php

namespace CedricZiel\CanvaBundle\Controller;

use Canva\Publish\FindRequest as CanvaFindRequest;
use Canva\Publish\GetResourceRequest as CanvaGetResourceRequest;
use Canva\Publish\UploadRequest as CanvaUploadRequest;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class PublishResourcesController
{
    public function find(SymfonyRequest $request, CanvaFindRequest $findRequest)
    {
        throw new NotAcceptableHttpException();
    }

    public function get(SymfonyRequest $request, CanvaGetResourceRequest $getResourceRequest)
    {
        throw new NotAcceptableHttpException();
    }

    public function upload(SymfonyRequest $request, CanvaUploadRequest $uploadRequest)
    {
        throw new NotAcceptableHttpException();
    }
}
