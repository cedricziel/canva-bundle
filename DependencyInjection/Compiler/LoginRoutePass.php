<?php

namespace CedricZiel\CanvaBundle\DependencyInjection\Compiler;

use CedricZiel\CanvaBundle\EventListener\RegisterCanvaIdWithUserListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LoginRoutePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $canvaConfig = $container->getExtensionConfig('canva');

        $listenerConfiguration = $container->getDefinition(RegisterCanvaIdWithUserListener::class);
        $listenerConfiguration->setArgument(2, $canvaConfig[0]['login_route']);
    }
}
