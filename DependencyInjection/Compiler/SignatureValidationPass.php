<?php

namespace CedricZiel\CanvaBundle\DependencyInjection\Compiler;

use CedricZiel\CanvaBundle\EventListener\SignatureValidationListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SignatureValidationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
       if ($container->getParameter('canvaSecret') === null) {
           $container->removeDefinition(SignatureValidationListener::class);
       }
    }
}
