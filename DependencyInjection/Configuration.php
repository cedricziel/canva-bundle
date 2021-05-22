<?php

namespace CedricZiel\CanvaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('canva');
        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('extensions')
                ->useAttributeAsKey('id')
                ->arrayPrototype()
                    ->children()
                        ->scalarNode('id')->end()
                        ->scalarNode('secret')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
            ->scalarNode('login_route')->isRequired()->end()
        ;

        return $treeBuilder;
    }
}
