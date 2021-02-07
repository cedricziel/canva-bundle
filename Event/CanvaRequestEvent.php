<?php

namespace CedricZiel\CanvaBundle\Event;

use Canva\Request;
use Canva\Response;
use Symfony\Contracts\EventDispatcher\Event;

abstract class CanvaRequestEvent extends Event
{
    abstract public function setResponse(?Response $response): self;

    abstract public function getResponse(): Response;

    abstract public function getRequest(): Request;
}
