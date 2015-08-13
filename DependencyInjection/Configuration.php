<?php

namespace Kamran\LayoutBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;


class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kamran_layout');

        $rootNode
            ->children()
            ->scalarNode('_theme_bundle')->defaultValue('KamranThemeBundle')->end()
            ->end();
        $rootNode
            ->children()
            ->arrayNode('_theme_namespaces')
            ->isRequired()
            ->prototype('scalar')->end()
            ->end();

        return $treeBuilder;
    }
}