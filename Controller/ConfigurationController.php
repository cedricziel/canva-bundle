<?php

namespace CedricZiel\CanvaBundle\Controller;

use Canva\Configuration\Request\ConfigurationRequest;
use CedricZiel\CanvaBundle\Event\Configuration\ConfigurationDeleteEvent;
use CedricZiel\CanvaBundle\Event\Configuration\ConfigurationEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfigurationController extends AbstractController
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function add(Request $request, ConfigurationRequest $configurationRequest)
    {
        $event = new ConfigurationEvent($configurationRequest);

        $this->eventDispatcher->dispatch($event);

        return new JsonResponse($event->getResponse());
    }

    public function delete(Request $request, ConfigurationRequest $configurationRequest)
    {
        $event = new ConfigurationDeleteEvent($configurationRequest);

        $this->eventDispatcher->dispatch($event);

        return new JsonResponse($event->getResponse());
    }
}
