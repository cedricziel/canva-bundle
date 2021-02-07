<?php

namespace CedricZiel\CanvaBundle\Routing;

use CedricZiel\CanvaBundle\Controller\ConfigurationController;
use CedricZiel\CanvaBundle\Controller\ContentResourcesController;
use CedricZiel\CanvaBundle\Controller\PublishResourcesController;
use RuntimeException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class CanvaExtensionRouteLoader implements LoaderInterface
{
    private bool $loaded = false;

    private array $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function load($resource, string $type = null)
    {
        if (true === $this->loaded) {
            throw new RuntimeException('Do not add this loader twice');
        }

        $routes = new RouteCollection();

        $this->addConfigurationRoutes($routes);
        $this->addContentRoutes($routes);
        $this->addPublishRoutes($routes);

        $routes->addNamePrefix('canva_extension');

        return $routes;
    }

    /**
     * @param RouteCollection $routes
     */
    public function addConfigurationRoutes(RouteCollection $routes): void
    {
        // Configuration routes
        $configurationRoute = (new Route('/canva/extensions/{extension_id}/configuration'))
            ->setDefault('_controller', ConfigurationController::class . '::add')
            ->setMethods('POST');

        $configurationDeleteRoute = (new Route('/canva/extensions/{extension_id}/configuration/delete'))
            ->setDefault('_controller', ConfigurationController::class . '::delete')
            ->setMethods('POST');

        $routes->add('_configuration_delete', $configurationDeleteRoute);
        $routes->add('_configuration', $configurationRoute);
    }

    /**
     * @param RouteCollection $routes
     */
    public function addPublishRoutes(RouteCollection $routes): void
    {
            // Publish routes
        $publishResourcesFindRoute = (new Route('/canva/extensions/{extension_id}/publish/resources/find'))
            ->setDefault('_controller', PublishResourcesController::class . '::find')
            ->setMethods('POST');

        $publishResourcesGetRoute = (new Route('/canva/extensions/{extension_id}/publish/resources/get'))
            ->setDefault('_controller', PublishResourcesController::class . '::getAction')
            ->setMethods('POST');

        $publishResourcesUpload = (new Route('/canva/extensions/{extension_id}/publish/resources/upload'))
            ->setDefault('_controller', PublishResourcesController::class . '::upload')
            ->setMethods('POST');

        $routes->add('_publish_resources_find', $publishResourcesFindRoute);
        $routes->add('_publish_resources_get', $publishResourcesGetRoute);
        $routes->add('_publish_resources_upload', $publishResourcesUpload);
    }

    /**
     * @param RouteCollection $routes
     */
    public function addContentRoutes(RouteCollection $routes): void
    {
        // Publish routes
        $contentFindRoute = (new Route('/canva/extensions/{extension_id}/content/resources/find'))
            ->setDefault('_controller', ContentResourcesController::class . '::find')
            ->setMethods('POST');

        $routes->add('_content_resources_find', $contentFindRoute);
    }

    public function supports($resource, string $type = null)
    {
        return 'canva_extensions' === $type;
    }

    public function getResolver()
    {
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
        // irrelevant to us, since we don't need a resolver
    }
}
