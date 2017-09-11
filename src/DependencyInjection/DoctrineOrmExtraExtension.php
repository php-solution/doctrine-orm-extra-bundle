<?php

namespace PhpSolution\Doctrine\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * DoctrineOrmExtraExtension
 */
class DoctrineOrmExtraExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (array_key_exists('entity_cache_map', $config)) {
            $def = $container->findDefinition('doctrine_extra.orm.event_listener.cache_entity');
            $mappingConfig = $config['entity_cache_map'];
            foreach ($config['entity_cache_map'] as $entityName => $configItem) {
                $def->addMethodCall('setCacheMap', [$entityName, $configItem['region'], $configItem['usage']]);
            }
            if (count($mappingConfig) > 0) {
                $def->addTag('doctrine.event_listener', ['event' => 'loadClassMetadata']);
            }
        }
    }
}
