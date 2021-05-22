<?php

namespace CedricZiel\CanvaBundle;

use CedricZiel\CanvaBundle\DependencyInjection\Compiler\LoginRoutePass;
use CedricZiel\CanvaBundle\DependencyInjection\Compiler\SignatureValidationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CanvaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new LoginRoutePass());
        $container->addCompilerPass(new SignatureValidationPass());
    }
}
