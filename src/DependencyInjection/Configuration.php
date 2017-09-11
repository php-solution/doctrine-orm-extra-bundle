<?php

namespace PhpSolution\Doctrine\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('doctrine_orm_extra');

        $root
            ->children()
                ->arrayNode('entity_cache_map')
                    ->prototype('array')
                    ->children()
                        ->enumNode('usage')
                            ->values(['READ_ONLY', 'NONSTRICT_READ_WRITE', 'READ_WRITE'])
                        ->end()
                        ->scalarNode('region')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
