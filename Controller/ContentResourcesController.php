<?php

namespace CedricZiel\CanvaBundle\Controller;

use Canva\Content\Request\FindRequest;
use CedricZiel\CanvaBundle\Event\Content\FindRequestEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContentResourcesController extends AbstractController
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function find(FindRequest $canvaRequest)
    {
        $event = new FindRequestEvent($canvaRequest);

        $this->eventDispatcher->dispatch($event);

        return new JsonResponse($event->getResponse());
    }
}
