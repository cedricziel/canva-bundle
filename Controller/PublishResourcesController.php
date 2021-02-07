<?php

namespace CedricZiel\CanvaBundle\Controller;

use Canva\Publish\Request\FindRequest as CanvaFindRequest;
use Canva\Publish\Request\GetResourceRequest as CanvaGetResourceRequest;
use Canva\Publish\Request\UploadRequest as CanvaUploadRequest;
use CedricZiel\CanvaBundle\Event\Publish\FindRequestEvent;
use CedricZiel\CanvaBundle\Event\Publish\GetRequestEvent;
use CedricZiel\CanvaBundle\Event\Publish\UploadRequestEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PublishResourcesController extends AbstractController
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function find(CanvaFindRequest $findRequest)
    {
        $event = new FindRequestEvent($findRequest);

        $this->dispatcher->dispatch($event);

        return new JsonResponse($event->getResponse());
    }

    public function getAction(CanvaGetResourceRequest $getResourceRequest)
    {
        $event = new GetRequestEvent($getResourceRequest);

        $this->dispatcher->dispatch($event);

        return new JsonResponse($event->getResponse());
    }

    public function upload(CanvaUploadRequest $uploadRequest)
    {
        $event = new UploadRequestEvent($uploadRequest);

        $this->dispatcher->dispatch($event);

        return new JsonResponse($event->getResponse());
    }
}
