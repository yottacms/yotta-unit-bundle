<?php

namespace YottaCms\Bundle\YottaUnitBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * YottaUnitBundle configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('yotta_unit');

        $rootNode
            ->children()
                ->arrayNode('items')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('type')->end()
                            ->scalarNode('name')->end()
                            ->scalarNode('description')->end()
                            ->scalarNode('ico')->end()
                            ->scalarNode('version')->end()
                            ->scalarNode('entry_point')->end()
                        ->end()
                   ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
