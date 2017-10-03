<?php

namespace YottaCms\Bundle\YottaUnitBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class YottaUnitExtension extends Extension
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
                    
        $container->setParameter('yotta_unit.items', $this->mergeConfigUnits($configs));
    }

    /**
     * Merge all units parameters for yotta cms
     * @param  array  $configs
     * @return array
     */
    protected function mergeConfigUnits(array $configs) 
    {
        
        $configMerged = array();
        foreach ($configs as $subConfig) {
            $configMerged = array_merge_recursive($configMerged, $subConfig);
        }
        
        return $configMerged['items'] ?? array();

    }
}
