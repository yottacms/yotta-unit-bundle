<?php

namespace YottaCms\Bundle\YottaUnitBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use YottaCms\Bundle\YottaUnitBundle\DependencyInjection\YottaUnitExtension;

class YottaUnitExtensionTest extends TestCase
{
    /** @var ContainerBuilder */
    protected $configuration;

    public function testLoadFormServiceWithDefaults()
    {
        $this->createEmptyConfiguration();        
        $this->assertHasDefinition('YottaCms\Bundle\YottaUnitBundle\UnitManager\Manager');
        $this->assertHasDefinition('yotta.unit_manager');
    }
    
    public function testMergeConfigUnits()
    {
        $this->createConfiguration();
        $this->assertTrue($this->configuration->getParameter('yotta_unit.items') === $this->getConfig()['items']);
    }

    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new YottaUnitExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
    }
    
    protected function createConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new YottaUnitExtension();
        $config = $this->getConfig();
        $loader->load(array($config), $this->configuration);
    }
    
    /**
     * @param string $id
     */
    protected function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }
    
    /**
     * getEmptyConfig.
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        return array();
    }
    
    /**
     * getConfig.
     *
     * @return array
     */
    protected function getConfig()
    {
        return array(
            'items' => array(
                'test_1'    => array(
                    'type'  => 'bundle',
                    'name'  => 'test_1 name',
                ),
                'test_2'    => array(
                    'type'  => 'bundle',
                    'name'  => 'test_2 name',
                )
            )
        );
    }
    
}
