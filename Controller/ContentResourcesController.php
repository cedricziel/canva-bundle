<?php

namespace CedricZiel\CanvaBundle\Controller;

use Canva\Content\Request\FindRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class ContentResourcesController extends AbstractController
{
    public function find(SymfonyRequest $request, FindRequest $canvaRequest)
    {
        throw new NotAcceptableHttpException();
    }
}
