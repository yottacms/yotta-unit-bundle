<?php

namespace YottaCms\Bundle\YottaUnitBundle\Tests\DependencyInjection;

use Symfony\Bundle\FullStack;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use PHPUnit\Framework\TestCase;
use YottaCms\Bundle\YottaUnitBundle\DependencyInjection\Configuration;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(true), [[
            'items' => $this->getUnitSampleConfig()
        ]]);
        
        $this->assertEquals(
            array('items' => $this->getUnitSampleConfig()),
            $config
        );

    }
    protected function getUnitSampleConfig()
    {
        return [
            'yotta_test_unit' => array(
                'type'  => 'bundle',
                'name'  => 'yotta_test_unit name',
                'description'   => 'yotta_test_unit description',
                'icon'   => 'yotta_test_unit ico',
                'version'   => 'yotta_test_unit version',
                'entry_point'   => 'yotta_test_unit entry_point',
            )
        ];
    }
}
